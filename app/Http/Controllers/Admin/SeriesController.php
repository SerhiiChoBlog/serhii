<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Series;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SeriesController extends Controller
{
    /**
     * @return LengthAwarePaginator<Series>
     */
    public function index(): LengthAwarePaginator
    {
        return Series::query()->paginate(10);
    }

    public function store(Request $request): RedirectResponse
    {
        return back();
    }

    public function edit(Series $series): Series
    {
        return $series;
    }

    public function update(Request $request, Series $series): Series
    {
        return $series;
    }

    public function destroy(Series $series): void
    {
        $series->delete();
    }
}
