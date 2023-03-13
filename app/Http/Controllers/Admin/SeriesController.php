<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Series\StoreRequest;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class SeriesController extends Controller
{
    /**
     * @return LengthAwarePaginator<Series>
     */
    public function index(): LengthAwarePaginator
    {
        return Series::query()->paginate(10);
    }

    public function store(StoreRequest $request): Series
    {
        /** @var Series $series */
        $series = Series::query()->create([
            'title' => $request->title,
            'intro' => $request->intro,
            'description' => $request->description,
            'slug' => Str::slug($request->title),
        ]);

        if (!empty($request->posts)) {
            $series->posts()->sync($request->posts);
        }

        return $series;
    }

    public function edit(Series $series): Series
    {
        $series->load('posts');
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
