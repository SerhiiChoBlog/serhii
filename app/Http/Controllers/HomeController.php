<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\CacheKey;
use App\Models\Post;
use App\Models\PostView;
use App\Models\Video;
use App\Services\PreferredPostsService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    private const SELECT_FIELDS = [
        'id',
        'slug',
        'title',
        'intro',
        'image_sm',
        'image_xs',
        'created_at',
        'read_time',
    ];

    /**
     * @var array<int, int>
     */
    private array $exclude_ids = [];

    public function index(): View
    {
        $latest = Cache::rememberForever(CacheKey::LATEST_POSTS, fn () => $this->getLatest());
        $monthly_top = Cache::rememberForever(CacheKey::TOP_LAST_MONTH, fn () => $this->getMonthlyTop());

        $this->exclude_ids = [
            ...array_column($latest, 'id'),
            ...array_column($monthly_top, 'id'),
        ];

        return view('home', [
            'latest_videos' => $this->getLatestVideos(),
            'latest' => $latest,
            'monthly_top' => $monthly_top,
            'posts' => $this->getPreferredPosts(),
        ]);
    }

    /**
     * @return array<int, Post>
     */
    private function getLatest(): array
    {
        return Post::query()
            ->select(self::SELECT_FIELDS)
            ->latest()
            ->where('is_published', true)
            ->limit(2)
            ->get()
            ->all();
    }

    /**
     * @return array<int, Post>
     */
    private function getMonthlyTop(): array
    {
        $monthly = PostView::query()
            ->selectRaw('post_id, COUNT(*) as amount')
            ->whereMonth('created_at', now()->subMonth())
            ->groupBy('post_id')
            ->orderByDesc('amount')
            ->limit(2)
            ->get();

        $result = Post::query()
            ->whereIn('id', $monthly->pluck('post_id'))
            ->select(self::SELECT_FIELDS)
            ->where('is_published', true)
            ->get();

        $result->map(function (Post $post) use ($monthly) {
            $match = $monthly->where('post_id', $post->id)->first();

            if ($match) {
                $post->post_views_count = $match->amount;
            }

            return $post;
        });

        return $result->all();
    }

    /**
     * @return array<int, Post>
     */
    private function getPreferredPosts(): array
    {
        $service = new PreferredPostsService();
        return $service->get($this->exclude_ids)->all();
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
