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

        $result = Post::query()
            ->with('series:id,title,slug')
            ->with('tags:id,name,color,title')
            ->whereIn('id', $monthly->pluck('post_id'))
            ->select(Post::COMMON_FIELDS)
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
}
