<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SeriesController extends Controller
{
    public function index(): View
    {
        $series = Series::query()
            ->withCount('posts')
            ->with(['posts' => function (BelongsToMany $q) {
                $q->where('is_published', true);
            }])
            ->paginate(10);

        return view('series.index', compact('series'));
    }

    public function show(): View
    {
        return view('series.show');
    }
}
