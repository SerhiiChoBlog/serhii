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
            'last_visit' => $this->getLastVisit(),
            'visitors_count' => Number::conv(Visitor::query()->count()),
        ]);
    }

    private function getLastVisit(): string
    {
        $last_visit = PageView::query()
            ->latest('updated_at')
            ->first();

        if (!$last_visit) {
            return '';
        }

        return TimeAgo::trans($last_visit->updated_at->toDateTimeString());
    }
}
