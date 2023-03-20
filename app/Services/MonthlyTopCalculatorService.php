<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Post;
use App\Models\PostView;

readonly class MonthlyTopCalculatorService
{
    /**
     * @return array<int, Post>
     */
    public function calculate(int $amount): array
    {
        $monthly = PostView::query()
            ->selectRaw('post_id, COUNT(*) as amount')
            ->whereMonth('created_at', (string) now()->subMonth()->month)
            ->groupBy('post_id')
            ->orderByDesc('amount')
            ->limit($amount)
            ->get();

        return Post::query()
            ->with('series:id,title,slug')
            ->with('tags:id,name,color,title')
            ->whereIn('id', $monthly->pluck('post_id'))
            ->select(Post::COMMON_FIELDS)
            ->where('is_published', true)
            ->get()
            ->all();
    }
}
