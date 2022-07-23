<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class VisitorController extends Controller
{
    public function index(): View
    {
        /** @var Collection<int, Visitor> $visitors */
        $visitors = Visitor::query()
            ->selectRaw('*, LOWER(code) as code')
            ->withCount('pageViews')
            ->limit(100)
            ->orderByDesc('page_views_count')
            ->get();

        return view('admin.visitors.index', compact('visitors'));
    }
}
