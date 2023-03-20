<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\CacheKey;
use App\Models\Post;
use App\Models\PostView;
use App\Models\Video;
use App\Services\PreferredPostsService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
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
        return view('home', [
            'latest_videos' => $this->getLatestVideos(),
            'latest' => $this->getLatest(),
            'monthly_top' => $this->getMonthlyTop(),
            'posts' => $this->getPreferredPosts(),
        ]);
    }

    /**
     * @return Collection<int, Post>
     */
    private function getLatest(): Collection
    {
        $result = Post::query()
            ->select(self::SELECT_FIELDS)
            ->latest()
            ->where('is_published', true)
            ->limit(2)
            ->get();

        $this->exclude_ids = array_merge($this->exclude_ids, $result->pluck('id')->toArray());

        return $result;
    }

    /**
     * @return Collection<int, Post>
     */
    private function getMonthlyTop(): Collection
    {
        $monthly = PostView::query()
            ->selectRaw('post_id, COUNT(*) as amount')
            ->whereMonth('created_at', (string) now()->month)
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
            $post->post_views_count = $monthly->where('post_id', $post->id)->first()->amount;
            return $post;
        });

        $this->exclude_ids = array_merge($this->exclude_ids, $result->pluck('id')->toArray());

        return $result;
    }

    /**
     * @return Collection<int, Post>
     */
    private function getPreferredPosts(): Collection
    {
        $service = new PreferredPostsService();
        return $service->get($this->exclude_ids);
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
