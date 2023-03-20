<?php

declare(strict_types=1);

namespace App\View\Components\Home;

use App\CacheKey;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class ComingSoonSection extends Component
{
    public function render(): View
    {
        return view('components.home.coming-soon-section', [
            'posts' => $this->getPosts(),
        ]);
    }

    /**
     * @return array<int, Post>
     */
    private function getPosts(): array
    {
        return Cache::rememberForever(CacheKey::UPCOMING, function () {
            return Post::query()
                ->with('tags:name,color,title')
                ->with('series:id,title')
                ->select('id', 'title', 'intro', 'image_sm', 'slug', 'updated_at')
                ->where('is_published', false)
                ->latest('updated_at')
                ->get()
                ->all();
        });
    }
}
