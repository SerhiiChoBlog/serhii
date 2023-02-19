<?php

declare(strict_types=1);

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
            ->whereNotIn('name', ['php', 'agnostic', 'web'])
            ->limit(5)
            ->get()
            ->toArray();
    }
}
