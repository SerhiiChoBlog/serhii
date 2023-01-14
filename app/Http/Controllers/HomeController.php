<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\CacheKey;
use App\Models\Post;
use App\Models\Video;
use App\Ttl;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'latest_posts' => $this->getLatestPosts(),
            'random_posts' => $this->getRandomPosts(),
            'latest_videos' => $this->getLatestVideos(),
        ]);
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    private function getRandomPosts(): array
    {
        return Cache::remember(CacheKey::HOME_RANDOM_POSTS, Ttl::HOUR, static function () {
            $last_posts = Cache::get(CacheKey::LAST_POSTS);

            return Post::with('tags:name,color,title')
                ->select('id', 'slug', 'title', 'intro', 'image_sm', 'image_xs', 'created_at', 'read_time')
                ->whereNotIn('id', array_column($last_posts, 'id'))
                ->where('is_published', true)
                ->limit(3)
                ->inRandomOrder()
                ->get()
                ->toArray();
        });
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    private function getLatestPosts(): array
    {
        return Cache::rememberForever(CacheKey::LAST_POSTS, static function () {
            return Post::query()
                ->with('tags:name,color,title')
                ->select('id', 'slug', 'title', 'intro', 'image_sm', 'image_xs', 'created_at', 'read_time')
                ->where('is_published', true)
                ->orderByDesc('created_at')
                ->limit(3)
                ->get()
                ->toArray();
        });
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    private function getLatestVideos(): array
    {
        return Cache::rememberForever(CacheKey::LAST_VIDEOS, static function () {
            return Video::query()
                ->orderByDesc('created_at')
                ->limit(4)
                ->get()
                ->toArray();
        });
    }
}
