<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageView;
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
                'title' => '-',
                'value' => '-',
            ],
            [
                'title' => '-',
                'value' => '-',
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
}
