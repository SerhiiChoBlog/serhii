<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\CacheKey;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\StoreRequest;
use App\Models\Post;
use App\Utils\SaveImage;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
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
            ->with(['tags', 'images'])
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

    public function edit(Post $post): Post
    {
        $post->load('tags', 'images');

        return $post;
    }

    /**
     * @param Request $request
     * @param Post $post
     *
     * @return string
     * @throws JsonException
     */
    public function update(Request $request, Post $post): string
    {
        $post->tags()->detach();

        if ($request->has('tags')) {
            $tags = json_decode($request->get('tags'), true, 512, JSON_THROW_ON_ERROR);
            $post->tags()->attach($tags);
        }

        $is_published = $request->boolean('is-published');

        $data = array_merge($request->all(), compact('is_published'));

        /** @var UploadedFile $photo */
        $photo = $request->file('image');

        $images = $this->savePhotoIfExist($photo, $post->title);

        if ($images) {
            $data = array_merge($data, ['image_sm' => $images['sm'], 'image_lg' => $images['lg']]);
        }

        $slug = Str::slug($request->get('title'));
        $data = array_merge($data, compact('slug'));

        $data['title'] = trim($data['title'] ?? '');
        $data['intro'] = trim($data['intro'] ?? '');
        $data['content'] = $this->addNotesToContent($data['content']);
        $data['read_time'] = Post::calculateEstimatedReadingTime($data['content'] ?? '');

        if ($post->is_published || $is_published) {
            Cache::forget(CacheKey::LAST_POSTS);
        }

        if (!$post->is_published && $is_published) {
            $data = array_merge($data, ['created_at' => now()]);
        }

        $post->update($data);

        return $slug;
    }

    private function addNotesToContent(?string $content): ?string
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

    public function destroy(Post $post): void
    {
        $post->images->each(static function ($image) {
            Storage::delete($image->path);
        });

        if ($post->is_published) {
            Cache::forget(CacheKey::LAST_POSTS);
        }

        $post->images()->delete();
        $post->tags()->detach();
        $post->delete();
    }
}
