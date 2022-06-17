<?php

namespace App\View\Components\Home;

use App\CacheKey;
use App\Models\Post;
use App\Ttl;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class LastPostsSection extends Component
{
    public function posts(): array
    {
        return Cache::remember(CacheKey::LAST_POSTS, Ttl::DAY, static function () {
            return Post::query()
                ->with('tags:name,color')
                ->select('id', 'slug', 'title', 'intro', 'image_sm', 'created_at')
                ->where('is_published', true)
                ->orderByDesc('created_at')
                ->limit(3)
                ->get()
                ->toArray();
        });
    }

    public function render(): View
    {
        return view('components.home.last-posts-section');
    }
}
