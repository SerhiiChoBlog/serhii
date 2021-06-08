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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    use SaveImage;

    public function index(): View
    {
        $posts = Post::query()->with(['tags', 'images'])->orderByDesc('created_at')->get();
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
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        $post->tags()->detach();

        if ($request->get('tags')) {
            $tags = json_decode($request->get('tags'), true, 512, JSON_THROW_ON_ERROR);
            $post->tags()->attach($tags);
        }

        $is_published = $request->boolean('is-published');

        $data = array_merge($request->all(), compact('is_published'));

        $images = $this->savePhotoIfExist($request->file('image'), $post->title);

        if ($images) {
            $data = array_merge($data, ['image_sm' => $images['sm'], 'image_lg' => $images['lg']]);
        }

        $data['title'] = trim($data['title']);
        $data['intro'] = trim($data['intro']);

        $post->update($data);

        if ($post->is_published) {
            Cache::forget(CacheKey::PUBLISHED_POSTS);
            Cache::forget(CacheKey::SIDEBAR_POSTS);
        }

        Cache::forget(CacheKey::POST . $post->slug);

        return redirect()->route('admin.posts.edit', $post);
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->images->each(static function ($image) {
            Storage::delete($image->path);
        });

        if ($post->is_published) {
            Cache::forget(CacheKey::PUBLISHED_POSTS);
            Cache::forget(CacheKey::SIDEBAR_POSTS);
        }

        $post->images()->delete();
        $post->tags()->detach();
        $post->delete();

        Cache::forget(CacheKey::POST . $post->slug);

        return redirect()->route('admin.posts.index');
    }
}
