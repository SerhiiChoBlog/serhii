<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\CacheKey;
use App\Console\Commands\SitemapCommand;
use App\Events\PostChanged;
use App\Exceptions\LazyLoadingConversionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\StoreRequest;
use App\Http\Requests\Admin\Post\UpdateRequest;
use App\LazyLoadingParser;
use App\Models\Post;
use App\Utils\SaveImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JsonException;

class PostController extends Controller
{
    use SaveImage;

    /**
     * @return Collection<int, Post>
     */
    public function index(): Collection
    {
        return Post::query()
            ->select('id', 'title', 'intro', 'slug', 'image_sm', 'image_lg', 'is_published')
            ->withCount('postViews')
            ->withCount('socialShares')
            ->latest()
            ->get();
    }

    public function store(StoreRequest $request): int
    {
        /** @var Post $post */
        $post = Post::query()->create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
        ]);

        return $post->id;
    }

    /**
     * @throws LazyLoadingConversionException
     */
    public function edit(Post $post): Post
    {
        $post->load('tags', 'images', 'video', 'keywords');

        if ($post->content) {
            $post->content = LazyLoadingParser::makeImagesNotLazy($post->content);
        }

        return $post;
    }

    /**
     * @throws JsonException
     * @throws LazyLoadingConversionException
     */
    public function update(UpdateRequest $request, Post $post): Post
    {
        $post->tags()->detach();

        if ($request->tags) {
            $this->attachTags($request->tags, $request->tag_id, $post);
        }

        $data = $request->collect()->forget(['_method', 'is-published', 'tag_id']);

        /** @var UploadedFile|null $image */
        $image = $request->file('image');

        $images = $this->savePhotoIfExist($image, $post->title);

        if ($images) {
            $data = $data->merge([
                'image_xs' => $images['xs'],
                'image_sm' => $images['sm'],
                'image_lg' => $images['lg'],
            ]);
        }

        $data['content'] = $this->addNotesToContent($request->content);

        if ($data['content']) {
            $data['content'] = LazyLoadingParser::makeImagesLazy($data['content']);
        }

        $data['read_time'] = Post::calculateEstimatedReadingTime($data['content'] ?? '');

        event(new PostChanged($post));

        $first_time_publish = !$post->is_published && $request->is_published;

        if ($first_time_publish) {
            $data = $data->merge(['created_at' => now()]);
            Artisan::call(SitemapCommand::class);
        }

        $post->update($data->toArray());

        return $this->edit($post);
    }

    public function destroy(Post $post): void
    {
        $post->images->each(static function ($image) {
            Storage::delete($image->path);
        });

        if ($post->is_published) {
            Cache::forget(CacheKey::RANDOM_POSTS);
            Cache::forget(CacheKey::HOME_POPULAR_POSTS);
        }

        $post->images()->delete();
        $post->tags()->detach();
        $post->postViews()->delete();
        $post->socialShares();
        $post->postPublication()->delete();
        $post->delete();

        event(new PostChanged(null));
    }

    private function addNotesToContent(?string $content): ?string
    {
        if (!$content) {
            return null;
        }

        return str_replace(
            ['<p>Note. ', '<p>Tip. ', '<p>Warning. '],
            ['<p class="note">', '<p class="tip">', '<p class="note">'],
            $content,
        );
    }

    /**
     * @param array<int, int> $tags
     */
    private function attachTags(array $tags, ?int $tag_id, Post $post): void
    {
        $data = [];

        foreach ($tags as $tag) {
            $data[$tag] = ['is_main' => $tag === $tag_id];
        }

        $post->tags()->attach($data);
    }
}
