<?php

namespace App\Http\Controllers\Api;

use App\CacheKey;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Ttl;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function index(): array
    {
        return Cache::remember(CacheKey::PUBLISHED_POSTS, Ttl::DAY, fn() => Post::getPublishedPosts()->toArray());
    }

    public function show(string $slug): array
    {
        $cache_key = CacheKey::POST . $slug;

        return Cache::remember($cache_key, Ttl::DAY, function () use ($slug) {
            $post = Post::query()
                ->with('tags:id,color,name')
                ->where('slug', $slug)
                ->select('title', 'intro', 'slug', 'content', 'image_lg', 'created_at')
                ->first();

            return $post ? $post->toArray() : null;
        });
    }
}
