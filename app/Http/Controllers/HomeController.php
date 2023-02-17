<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\CacheKey;
use App\Models\Post;
use App\Models\Video;
use App\Services\PreferredPostsService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'posts' => $this->getPreferredPosts(),
            'latest_videos' => $this->getLatestVideos(),
        ]);
    }

    /**
     * @return Collection<int, Post>
     */
    private function getPreferredPosts(): Collection
    {
        $service = new PreferredPostsService();
        return $service->get();
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
