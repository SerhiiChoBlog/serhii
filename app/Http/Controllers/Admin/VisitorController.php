<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Support\Collection;

class VisitorController extends Controller
{
    /**
     * @return Collection<int, Visitor>
     */
    public function index(): Collection
    {
        return Visitor::query()
            ->selectRaw('*, LOWER(code) as code')
            ->withCount('postViews')
            ->limit(30)
            ->orderByDesc('post_views_count')
            ->get();
    }
}
