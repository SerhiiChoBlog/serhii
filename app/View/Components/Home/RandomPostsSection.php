<?php

namespace App\View\Components\Home;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RandomPostsSection extends Component
{
    public function posts(): array
    {
        return Post::query()
            ->with('tags:name,color')
            ->select('id', 'slug', 'title', 'intro', 'image_sm', 'created_at')
            ->where('is_published', true)
            ->inRandomOrder()
            ->limit(3)
            ->get()
            ->toArray();
    }

    public function render(): View
    {
        return view('components.home.random-posts-section');
    }
}
