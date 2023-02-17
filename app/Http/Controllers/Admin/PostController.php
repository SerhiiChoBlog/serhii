<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\CacheKey;
use App\Console\Commands\SitemapCommand;
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
        $post->load('tags', 'images', 'video');

        if ($post->content) {
            $post->content = LazyLoadingParser::makeImagesNotLazy($post->content);
        }

        return $post;
    }

    /**
     * @throws JsonException
     * @throws LazyLoadingConversionException
     */
    public function update(UpdateRequest $request, Post $post): string
    {
        $post->tags()->detach();

        if ($request->tags) {
            $post->tags()->attach($request->tags);
        }

        $data = $request->collect()->forget(['_method', 'is-published']);

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

        if ($request->is_published) {
            Cache::forget(CacheKey::LAST_POSTS);
            Cache::forget(CacheKey::HOME_POPULAR_POSTS);
        }

        $first_time_publish = !$post->is_published && $request->is_published;

        if ($first_time_publish) {
            $data = $data->merge(['created_at' => now()]);
            Artisan::call(SitemapCommand::class);
        }

        $post->update($data->toArray());

        return $request->slug;
    }

    public function destroy(Post $post): void
    {
        $post->images->each(static function ($image) {
            Storage::delete($image->path);
        });

        if ($post->is_published) {
            Cache::forget(CacheKey::LAST_POSTS);
            Cache::forget(CacheKey::HOME_POPULAR_POSTS);
        }

        $post->images()->delete();
        $post->tags()->detach();
        $post->postViews()->delete();
        $post->socialShares();
        $post->postPublication()->delete();
        $post->delete();
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
}
