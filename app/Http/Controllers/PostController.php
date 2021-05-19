<?php

namespace App\Http\Controllers;

use App\CacheKey;
use App\Models\Post;
use App\Models\Project;
use App\Models\Visitor;
use App\Ttl;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function index(): Viecanw
    {
        $posts = Cache::remember(CacheKey::PUBLISHED_POSTS, Ttl::DAY, fn() => Post::getPublishedPosts()->toArray());
        return view('posts.index', compact('posts'));
    }

    public function show(string $slug, Request $request): View
    {
        $cache_key = CacheKey::POST . $slug;

        /** @var array $post */
        $post = Cache::remember($cache_key, Ttl::DAY, function () use ($slug) {
            $post = Post::query()
                ->with('tags:id,color,name')
                ->where('slug', $slug)
                ->select('title', 'intro', 'slug', 'content', 'image_lg', 'created_at')
                ->first();

            return $post ? $post->toArray() : null;
        });

        $title_len = strlen($post['title']);

        $title_font_size = match (true) {
            $title_len <= 10 => '4.8em',
            $title_len > 10 && $title_len < 20 => '3.8em',
            $title_len >= 20 && $title_len < 30 => '3.4em',
            $title_len >= 30 && $title_len < 40 => '2.8em',
            $title_len >= 40 && $title_len < 50 => '2.4em',
            $title_len >= 50 && $title_len < 60 => '2.2em',
        };

        $projects = Project::getCachedProjects();

        Visitor::incrementPageViews($request->segment(2), 'post', $request->ip());

        return view('posts.show', compact('post', 'title_font_size', 'projects'));
    }
}
