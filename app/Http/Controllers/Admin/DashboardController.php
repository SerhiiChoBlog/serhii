<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use App\Models\Post;
use App\Models\Referrer;
use App\Models\SocialShare;
use App\Models\Visitor;
use Illuminate\Contracts\View\View;
use Serhii\Ago\TimeAgo;
use Serhii\ShortNumber\Number;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'sections' => $this->getSections(),
        ]);
    }
    private function getSections(): array
    {
        return [
            [
                'title' => 'Last visit',
                'value' => $this->getLastVisit(),
            ],
            [
                'title' => 'Visitors',
                'value' => Number::conv(Visitor::query()->count()),
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

    private function getLastVisit(): string
    {
        /** @var PageView|null $last_visit */
        $last_visit = PageView::query()->latest('updated_at')->first();

        if (!$last_visit) {
            return '';
        }

        return TimeAgo::trans($last_visit->updated_at->toDateTimeString());
    }

    private function getShares(): int
    {
        $posts_count = Post::query()->where('is_published', true)->count();
        $my_shares = $posts_count * 4;

        $all_shares = SocialShare::query()->count();

        return $all_shares - $my_shares;
    }
}
