<?php

namespace App\View\Components\Home;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ComingSoonSection extends Component
{
    public ?array $post;

    public function __construct()
    {
        $this->post = $this->getPost();
    }

    public function getPost(): ?array
    {
        return Post::query()
            ->with('tags:name,color')
            ->select('id', 'title', 'intro', 'image_sm', 'updated_at')
            ->where('is_published', false)
            ->latest()
            ->first()
            ?->toArray();
    }

    public function render(): View
    {
        return view('components.home.coming-soon-section');
    }
}
