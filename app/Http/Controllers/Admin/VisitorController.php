<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Contracts\View\View;

class VisitorController extends Controller
{
    public function index(): View
    {
        $ips = explode(',', config('app.ips_to_exclude_from_page_views'));

        $visitors = Visitor::query()
            ->selectRaw('*, LOWER(code) as code')
            ->withSum('pageViews', 'views')
            ->whereNotIn('ip', $ips)
            ->limit(50)
            ->orderBy('page_views_sum_views', 'DESC')
            ->get();

        return view('admin.visitors.index', compact('visitors'));
    }
}
