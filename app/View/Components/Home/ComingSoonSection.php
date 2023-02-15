<?php

declare(strict_types=1);

namespace App\View\Components\Home;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ComingSoonSection extends Component
{
    public array $posts;

    public function __construct()
    {
        $this->posts = $this->getPosts();
    }

    public function getPosts(): array
    {
        return Post::query()
            ->with('tags:name,color,title')
            ->select('id', 'title', 'intro', 'image_sm', 'slug', 'updated_at')
            ->where('is_published', false)
            ->latest('updated_at')
            ->get()
            ->toArray();
    }

    public function render(): View
    {
        return view('components.home.coming-soon-section');
    }
}
