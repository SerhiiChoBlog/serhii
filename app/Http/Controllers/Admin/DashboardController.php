<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hit;
use App\Models\PageView;
use App\Models\Post;
use App\Models\Referrer;
use App\Models\SocialShare;

class DashboardController extends Controller
{
    public function sections(): array
    {
        return [
            [
                'title' => 'Post views today',
                'value' => PageView::query()
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
                'title' => 'Referrers',
                'value' => Referrer::query()->sum('hits'),
            ],
            [
                'title' => 'Guest shares',
                'value' => $this->getShares(),
            ],
        ];
    }

    private function getShares(): int
    {
        $posts_count = Post::query()->where('is_published', true)->count();
        $my_shares = $posts_count * 4;

        $all_shares = SocialShare::query()->count();

        return $all_shares - $my_shares;
    }
}
