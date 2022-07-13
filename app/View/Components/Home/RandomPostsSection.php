<?php

namespace App\View\Components\Home;

use App\CacheKey;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
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
        $last_post = Cache::get(CacheKey::LAST_POST);

        return Post::query()
            ->with('tags:name,color')
            ->select('id', 'slug', 'title', 'intro', 'image_sm', 'created_at', 'read_time')
            ->where('is_published', true)
            ->limit(3)
            ->when($last_post, fn(Builder $query) => $query->whereNot('id', $last_post['id']))
            ->inRandomOrder()
            ->get();
    }

    public function render(): View
    {
        return view('components.home.random-posts-section');
    }
}
