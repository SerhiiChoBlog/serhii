<?php

namespace App\View\Components\Home;

use App\CacheKey;
use App\Models\Post;
use App\Ttl;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class RandomPostsSection extends Component
{
    public function render(): View
    {
        return view('components.home.random-posts-section', [
            'posts' => $this->getRandomPosts(),
        ]);
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    private function getRandomPosts(): array
    {
        return Cache::remember(CacheKey::HOME_RANDOM_POSTS, Ttl::HOUR, static function () {
            $last_posts = Cache::get(CacheKey::LAST_POSTS);

            $query = Post::with('tags:name,color,title')
                ->select('id', 'slug', 'title', 'intro', 'image_sm', 'image_xs', 'created_at', 'read_time');

            if ($last_posts) {
                $query = $query->whereNotIn('id', array_column($last_posts, 'id'));
            }

            return $query
                ->where('is_published', true)
                ->limit(3)
                ->inRandomOrder()
                ->get()
                ->toArray();
        });
    }
}
