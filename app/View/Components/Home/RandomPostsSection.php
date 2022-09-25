<?php

namespace App\View\Components\Home;

use App\CacheKey;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class RandomPostsSection extends Component
{
    /**
     * @return Collection<int, Post>
     */
    public function posts(): Collection
    {
        $last_posts = Cache::get(CacheKey::LAST_POSTS);

        return Post::query()
            ->with('tags:name,color,title')
            ->select('id', 'slug', 'title', 'intro', 'image_sm', 'created_at', 'read_time')
            ->whereNotIn('id', array_column($last_posts, 'id'))
            ->where('is_published', true)
            ->limit(3)
            ->inRandomOrder()
            ->get();
    }

    public function render(): View
    {
        return view('components.home.random-posts-section');
    }
}
