<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\CacheKey;
use App\Models\Post;
use App\Models\Video;
use App\Recommendations\Filters\ExclusionFilter;
use App\Recommendations\Filters\LikedPostsFilter;
use App\Recommendations\RecommendationSystem;
use App\Services\MonthlyTopCalculatorService;
use App\Ttl;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * @var Collection<int, int>
     */
    private Collection $exclude_ids;

    public function __construct()
    {
        $this->exclude_ids = collect();
    }

    public function index(): View
    {
        $latest = $this->getLatest();
        $monthly_top = $this->getMonthlyTop();

        $this->exclude_ids->push(...array_column($latest, 'id'));
        $this->exclude_ids->push(...array_column($monthly_top, 'id'));

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
        return Cache::rememberForever(CacheKey::LATEST_POSTS, function () {
            return Post::query()
                ->with([
                    'series' => function (BelongsToMany $q) {
                        return $q->select('id', 'title', 'slug')->withCount('posts');
                    }
                ])
                ->with('tags:id,name,color,title')
                ->select(Post::COMMON_FIELDS)
                ->latest()
                ->where('is_published', true)
                ->limit(2)
                ->get()
                ->all();
        });
    }

    /**
     * @return array<int, Post>
     */
    private function getMonthlyTop(): array
    {
        return Cache::remember(CacheKey::TOP_LAST_MONTH, Ttl::DAY, function () {
            $service = new MonthlyTopCalculatorService();
            return $service->calculate(2);
        });
    }

    /**
     * @return Collection<int, Post>
     */
    private function getPreferredPosts(): Collection
    {
        return (new RecommendationSystem(6))
            ->pipe(new ExclusionFilter($this->exclude_ids))
            ->pipe(new LikedPostsFilter())
            ->get();
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
