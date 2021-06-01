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
            ->orderBy('amount', 'DESC')
            ->limit(50)
            ->get();

        return view('admin.page_views.index', compact('views'));
    }
}
