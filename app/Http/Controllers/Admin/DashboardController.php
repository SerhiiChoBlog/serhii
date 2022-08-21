<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hit;
use App\Models\PageView;
use App\Models\SocialShare;
use App\Models\Subscription;

class DashboardController extends Controller
{
    public function sections(): array
    {
        $confirmed_subs = Subscription::query()->whereNotNull('confirmed_at')->count();
        $not_confirmed_subs = Subscription::query()->count();

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
                'title' => 'Subscribers',
                'value' => "$confirmed_subs/$not_confirmed_subs",
            ],
            [
                'title' => 'Guest shares',
                'value' => SocialShare::query()->count(),
            ],
        ];
    }
}
