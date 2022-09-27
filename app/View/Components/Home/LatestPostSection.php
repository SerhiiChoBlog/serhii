<?php

namespace App\View\Components\Home;

use App\CacheKey;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class LatestPostSection extends Component
{
    public array $posts;

    public function __construct()
    {
        $this->posts = $this->getPosts();
    }

    public function getPosts(): ?array
    {
        Cache::forget(CacheKey::LAST_POSTS);
        return Cache::rememberForever(CacheKey::LAST_POSTS, static function () {
            return Post::query()
                ->with('tags:name,color,title')
                ->select('id', 'slug', 'title', 'intro', 'image_sm', 'created_at', 'read_time')
                ->where('is_published', true)
                ->orderByDesc('created_at')
                ->limit(2)
                ->get()
                ?->toArray();
        });
    }

    public function render(): View
    {
        return view('components.home.latest-post-section');
    }
}
