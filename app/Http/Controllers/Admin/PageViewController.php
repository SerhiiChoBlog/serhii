<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use Illuminate\Contracts\View\View;

class PageViewController extends Controller
{
    public function index(): View
    {
        $views = PageView::query()
            ->selectRaw('slug, SUM(views) as views')
            ->groupBy('slug')
            ->orderBy('views', 'DESC')
            ->limit(50)
            ->get();

        return view('admin.page_views.index', compact('views'));
    }
}
