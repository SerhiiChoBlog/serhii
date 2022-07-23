<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use Illuminate\Contracts\View\View;

class PageViewController extends Controller
{
    public function index(): View
    {
        $views = PageView::query()
            ->selectRaw('slug, COUNT(*) as amount')
            ->groupBy('slug')
            ->orderByDesc('amount')
            ->limit(50)
            ->get();

        foreach ($views->filter(fn($item) => $item->amount === 1) as $item) {
            PageView::query()->where('slug', $item->slug)->delete();
        }

        $daily = PageView::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as amount')
            ->groupBy('date')
            ->orderByDesc('date')
            ->limit(50)
            ->get();


        return view('admin.page_views.index', compact('views', 'daily'));
    }
}
