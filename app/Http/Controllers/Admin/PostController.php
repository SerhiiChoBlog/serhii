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
use App\Models\Series;
use App\Utils\ImageProcessor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JsonException;

class PostController extends Controller
{
    /**
     * @return LengthAwarePaginator<int, Post>
     */
    public function index(): LengthAwarePaginator
    {
        return Post::query()
            ->select('id', 'title', 'intro', 'slug', 'image_sm', 'image_lg', 'is_published', 'created_at')
            ->withCount('postViews')
            ->withCount('socialShares')
            ->latest()
            ->paginate(15);
    }

    public function store(StoreRequest $request): int
    {
        $series = $request->series
            ? Series::query()->withCount('posts')->find($request->series)
            : null;

        /** @var Post $post */
        $post = Post::query()->create([
            'title' => $request->title,
            'slug' => $this->getPostSlug($request->title, $series),
        ]);

        if ($series) {
            $posts_count = $series->posts_count ?? 0;
            $post->series()->attach([$series->id => ['part' => $posts_count + 1]]);
        }

        return $post->id;
    }

    public function show(string $post_slug): Post|null
    {
        /** @var Post|null */
        return Post::query()
            ->where('slug', $post_slug)
            ->first();
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
        $post->load('series');

        if ($request->tags) {
            $this->attachTags($request->tags, $request->tag_id, $post);
        }

        $data = $request->collect()->forget(['_method', 'is-published', 'tag_id']);

        /** @var UploadedFile|null $image */
        $image = $request->file('image');

        $image_processor = new ImageProcessor($image, [
            'xs' => [100, 50],
            'sm' => [550, 275],
            'lg' => [1000, 500],
        ]);

        $images = $image_processor->save($post->title, 'posts');

        if ($images) {
            $data->put('image_xs', $images['xs']);
            $data->put('image_sm', $images['sm']);
            $data->put('image_lg', $images['lg']);
        }

        $content = $this->addNotesToContent($request->content);

        if ($content) {
            $content = LazyLoadingParser::makeImagesLazy($content);
        }

        $data->put('slug', $this->getPostSlug($request->title, $post->series->first()));
        $data->put('read_time', Post::calculateEstimatedReadingTime($content ?? ''));
        $data->put('content', $content);

        $first_publish = !$post->is_published && $request->is_published;
        $first_unpublish = $post->is_published && !$request->is_published;

        if ($first_publish) {
            $data->put('created_at', now());
            Artisan::call(SitemapCommand::class);
        }

        Cache::forget(CacheKey::UPCOMING);

        if ($first_publish || $first_unpublish) {
            event(new PostChanged($post));
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
            Cache::forget(CacheKey::LATEST_POSTS);
        }

        Cache::forget(CacheKey::UPCOMING);

        $post->images()->delete();
        $post->tags()->detach();
        $post->postViews()->delete();
        $post->socialShares();
        $post->postPublication()->delete();
        $post->delete();

        event(new PostChanged(null));
    }

    private function addNotesToContent(string|null $content): string|null
    {
        if (!$content) {
            return null;
        }

        return str_replace(
            ['<p>Note. ', '<p>Tip. '],
            [
                '<p class="note"><span class="hidden" aria-label="Note">Note. </span>',
                '<p class="tip"><span class="hidden" aria-label="Tip">Tip. </span>',
            ],
            $content,
        );
    }

    /**
     * @param array<int, int> $tags
     */
    private function attachTags(array $tags, int|null $tag_id, Post $post): void
    {
        $data = [];

        foreach ($tags as $tag) {
            $data[$tag] = ['is_main' => $tag === $tag_id];
        }

        $post->tags()->attach($data);
    }

    private function getPostSlug(string $title, Series|null $series): string
    {
        $slug = Str::slug($title);
        return $series ? "{$series->slug}-{$slug}" : $slug;
    }
}
