<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hit;
use App\Models\Post;
use App\Models\Referrer;
use App\Models\SocialShare;
use Illuminate\Contracts\View\View;
use Serhii\Ago\Exceptions\InvalidDateFormatException;
use Serhii\Ago\Exceptions\MissingRuleException;
use Serhii\Ago\TimeAgo;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'sections' => $this->getSections(),
        ]);
    }

    /**
     * @throws InvalidDateFormatException
     * @throws MissingRuleException
     */
    private function getSections(): array
    {
        return [
            [
                'title' => 'Last visit',
                'value' => TimeAgo::trans(Hit::query()->latest()->value('updated_at')),
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
