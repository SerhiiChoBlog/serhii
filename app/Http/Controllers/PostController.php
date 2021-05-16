<?php

namespace App\Http\Controllers;

use App\CacheKey;
use App\Models\Post;
use App\Ttl;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Cache::remember(CacheKey::PUBLISHED_POSTS, Ttl::DAY, fn() => Post::getPublishedPosts()->toArray());
        return view('posts.index', compact('posts'));
    }

    public function show(string $slug): View
    {
        $cache_key = CacheKey::POST . $slug;

        $post = Cache::remember($cache_key, Ttl::DAY, function () use ($slug) {
            $post = Post::query()
                ->with('tags:id,color,name')
                ->where('slug', $slug)
                ->select('title', 'intro', 'slug', 'content', 'image_lg', 'created_at')
                ->first();

            return $post ? $post->toArray() : null;
        });

        return view('posts.show', compact('post'));
    }
}
