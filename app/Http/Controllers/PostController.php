<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\CacheKey;
use App\Models\Post;
use App\Models\Visitor;
use App\Ttl;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Cache::rememberForever(CacheKey::PUBLISHED_POSTS, function () {
            return Post::query()
                ->with('tags:id,name,color')
                ->select('id', 'slug', 'title', 'intro', 'image_sm', 'created_at')
                ->where('is_published', true)
                ->orderByDesc('created_at')
                ->paginate(15);
        });

        return view('posts.index', compact('posts'));
    }

    public function show(string $slug, Request $request): View
    {
        $cache_key = CacheKey::POST . $slug;

        $post = Cache::remember($cache_key, Ttl::HOUR, function () use ($slug) {
            $post = Post::query()
                ->with('tags:id,color,name')
                ->withCount('pageViews')
                ->where('slug', $slug)
                ->first();

            return $post ? $post->toArray() : null;
        });

        abort_if(!$post['is_published'] && !auth()->check(), 404);

        $title_len = strlen($post['title']);

        $title_font_size = match (true) {
            $title_len <= 10 => '4.8em',
            $title_len > 10 && $title_len < 20 => '3.8em',
            $title_len >= 20 && $title_len < 30 => '3.4em',
            $title_len >= 30 && $title_len < 40 => '2.8em',
            $title_len >= 40 && $title_len < 50 => '2.4em',
            $title_len >= 50 && $title_len < 60 => '2.2em',
        };

        $posts = Post::getPostsForSidebar($post['id']);

        Visitor::incrementPageViews($request->segment(2), 'post', $request->ip());

        return view('posts.show', compact('post', 'title_font_size', 'posts'));
    }
}
