<?php

namespace App\View\Components;

use App\CacheKey;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class LastPostsComponent extends Component
{
    public function posts(): array
    {
        return Cache::rememberForever(CacheKey::LAST_POSTS, function () {
            return Post::query()
                ->with('tags:name,color')
                ->select('id', 'slug', 'title', 'intro', 'image_sm', 'created_at')
                ->orderByDesc('created_at')
                ->limit(3)
                ->get()
                ->toArray();
        });
    }

    public function render(): View
    {
        return view('components.last-posts-component');
    }
}
