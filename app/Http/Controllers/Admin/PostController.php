<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\CacheKey;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Utils\SaveImage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JsonException;

class PostController extends Controller
{
    use SaveImage;

    public function index(): View
    {
        $posts = Post::query()
            ->with(['tags', 'images'])
            ->withCount('pageViews')
            ->withCount('socialShares')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('admin.posts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $title = $request->get('title');

        $post = Post::query()->create(['title' => $title, 'slug' => Str::slug($title)]);

        return redirect()->route('admin.posts.edit', $post);
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.edit', compact('post'));
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

        if ($request->get('tags')) {
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

        $data = array_merge($data, ['slug' => Str::slug($request->get('title'))]);

        $data['title'] = trim($data['title']);
        $data['intro'] = trim($data['intro']);
        $data['content'] = $this->addNotesToContent($data['content']);

        if ($post->is_published || $is_published) {
            $this->forgetPostsCache();
        }

        if (!$post->is_published && $is_published) {
            $data = array_merge($data, ['created_at' => now()]);
        }

        $post->update($data);

        Cache::forget(CacheKey::POST . $post->slug);

        return route('posts.show', $post);
    }

    private function addNotesToContent(?string $content): ?string
    {
        if (!$content) {
            return null;
        }

        return str_replace(
            ['<p>Note. ', '<p>Tip. '],
            ['<p class="note"><span class="d-none">Note. </span>', '<p class="tip"><span class="d-none">Tip. </span>'],
            $content,
        );
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->images->each(static function ($image) {
            Storage::delete($image->path);
        });

        if ($post->is_published) {
            $this->forgetPostsCache();
        }

        $post->images()->delete();
        $post->tags()->detach();
        $post->delete();

        Cache::forget(CacheKey::POST . $post->slug);

        return redirect()->route('admin.posts.index');
    }

    public function forgetPostsCache(): void
    {
        Cache::forget(CacheKey::PUBLISHED_POSTS);
        Cache::forget(CacheKey::LAST_POSTS);
    }
}
