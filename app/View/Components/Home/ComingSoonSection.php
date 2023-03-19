<?php

declare(strict_types=1);

namespace App\View\Components\Home;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ComingSoonSection extends Component
{
    /**
     * @var Collection<int, Post>
     */
    public Collection $posts;

    public function __construct()
    {
        $this->posts = $this->getPosts();
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return Post::query()
            ->with('tags:name,color,title', 'series')
            ->select('id', 'title', 'intro', 'image_sm', 'slug', 'updated_at')
            ->where('is_published', false)
            ->latest('updated_at')
            ->get();
    }

    public function render(): View
    {
        return view('components.home.coming-soon-section');
    }
}
