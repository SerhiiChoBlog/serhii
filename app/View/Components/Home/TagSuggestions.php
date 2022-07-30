<?php

namespace App\View\Components\Home;

use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TagSuggestions extends Component
{
    public function render(): View
    {
        return view('components.home.tag-suggestions');
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getTags(): array
    {
        return Tag::query()
            ->withCount('posts')
            ->orderByDesc('posts_count')
            ->limit(5)
            ->get()
            ->toArray();
    }
}
