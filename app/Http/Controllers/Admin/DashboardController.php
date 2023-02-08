<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Hit;
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
                'title' => 'Hits today',
                'value' => Hit::query()->whereDate('updated_at', today())->value('amount') ?? 0,
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
}
