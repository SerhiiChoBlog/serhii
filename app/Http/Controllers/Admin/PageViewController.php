<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use Illuminate\Support\Collection;

class PageViewController extends Controller
{
    /**
     * @return array{unique:Collection<int, PageView>, daily:Collection<int, PageView>}
     */
    public function index(): array
    {
        $unique = PageView::query()
            ->selectRaw('slug, COUNT(*) as amount')
            ->groupBy('slug')
            ->orderByDesc('amount')
            ->limit(50)
            ->get();

        $daily = PageView::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as amount')
            ->groupBy('date')
            ->orderByDesc('date')
            ->limit(50)
            ->get();

        return compact('unique', 'daily');
    }
}
