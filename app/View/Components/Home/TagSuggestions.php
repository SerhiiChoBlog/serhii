<?php

declare(strict_types=1);

namespace App\View\Components\Home;

use App\CacheKey;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class TagSuggestions extends Component
{
    public function render(): View
    {
        return view('components.home.tag-suggestions', [
            'tags' => $this->getTags(),
        ]);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function getTags(): array
    {
        return Cache::rememberForever(CacheKey::HOME_SEARCH_TAGS, function () {
            return Tag::query()
                ->withCount('posts')
                ->orderByDesc('posts_count')
                ->whereNotIn('name', ['php', 'agnostic', 'web'])
                ->limit(5)
                ->get()
                ->toArray();
        });
    }
}
