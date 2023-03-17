<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostView;
use App\Models\Referrer;
use App\Models\SocialShare;
use App\Models\Subscription;
use App\Models\User;

class DashboardController extends Controller
{
    public function sections(): array
    {
        $subs = Subscription::query()->select(['id', 'confirmed_at'])->get();
        $posts = Post::query()->select(['id', 'is_published'])->get();
        $comments = Comment::query()->select(['id', 'is_approved'])->get();

        return [
            [
                'title' => 'Post views today',
                'value' => PostView::query()
                    ->selectRaw('DATE(created_at) as date, COUNT(*) as amount')
                    ->groupBy('date')
                    ->orderByDesc('date')
                    ->first()
                    ?->amount,
            ],
            [
                'title' => 'Subscribers',
                'value' => sprintf("%s/%s", $subs->whereNotNull('confirmed_at')->count(), $subs->count()),
            ],
            [
                'title' => 'Shares',
                'value' => SocialShare::query()->count(),
            ],
            [
                'title' => 'Posts',
                'value' => sprintf('%d/%d', $posts->where('is_published', true)->count(), $posts->count()),
            ],
            [
                'title' => 'Refers',
                'value' => Referrer::query()->sum('hits'),
            ],
            [
                'title' => 'Users',
                'value' => User::query()->count(),
            ],
            [
                'title' => 'Comments',
                'value' => sprintf('%d/%d', $comments->where('is_approved', true)->count(), $comments->count())
            ],
        ];
    }

    public function goals(): array
    {
        $posts_this_week = Post::query()
            ->where('is_published', true)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        $posts_this_month = Post::query()
            ->where('is_published', true)
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

        $posts_this_year = Post::query()
            ->where('is_published', true)
            ->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()])
            ->count();

        return [
            [
                'title' => 'Weekly goal',
                'goal' => 'Publish 2 posts',
                'min' => $posts_this_week,
                'max' => 2,
            ],
            [
                'title' => 'Monthly goal',
                'goal' => 'Publish 8 posts',
                'min' => $posts_this_month,
                'max' => 8,
            ],
            [
                'title' => 'Yearly goal',
                'goal' => 'Publish 96 posts',
                'min' => $posts_this_year,
                'max' => now()->year === 2023 ? 80 : 96,
            ],
        ];
    }
}
