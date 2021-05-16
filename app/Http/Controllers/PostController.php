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

    public function show(): View
    {
        return view('posts.show');
    }
}
