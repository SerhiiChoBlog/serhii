<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class SeriesController extends Controller
{
    public function index(): View
    {
        $series = Series::query()
            ->withCount('posts')
            ->with(['posts' => function (BelongsToMany $q) {
                $q->select('id', 'title', 'image_xs', 'image_sm', 'slug', 'is_published');
            }])
            ->whereHas('posts', fn (Builder $q) => $q->where('is_published', true))
            ->orderByDesc('created_at')
            ->paginate(5);

        $series->each(function (Series $series) {
            $series->description = Str::limit($series->description, 400);
        });

        return view('series.index', compact('series'));
    }

    public function show(Series $series): View
    {
        $series->loadCount('posts');

        $series->load(['posts' => function (BelongsToMany $q) {
            $q->select('id', 'title', 'image_xs', 'image_sm', 'slug', 'is_published');
        }]);

        return view('series.show', compact('series'));
    }
}
