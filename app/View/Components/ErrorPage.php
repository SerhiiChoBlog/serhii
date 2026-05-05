<?php

declare(strict_types=1);

namespace App\View\Components;

use App\CacheKey;
use App\Models\Post;
use App\Ttl;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class ErrorPage extends Component
{
    public function __construct(
        public string $header,
        public int $code,
    ) {
    }

    public function render(): View
    {
        return view('components.error-page', [
            'posts' => $this->getPosts(),
            'links' => $this->getLinks(),
        ]);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function getPosts(): array
    {
        return Cache::remember(CacheKey::ERROR_RANDOM_POSTS, Ttl::HOUR, static function () {
            return Post::query()
                ->select('id', 'slug', 'title', 'intro', 'image_sm', 'read_time')
                ->where('is_published', true)
                ->limit(3)
                ->inRandomOrder()
                ->get()
                ->toArray();
        });
    }

    private function getLinks(): array
    {
        return [
            'Go home' => route('home'),
            'Blog' => route('posts.index'),
        ];
    }
}
