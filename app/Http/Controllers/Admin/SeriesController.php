<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Series\StoreRequest;
use App\Http\Requests\Admin\Series\UpdateRequest;
use App\Models\Series;
use App\Utils\SaveImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class SeriesController extends Controller
{
    use SaveImage;

    /**
     * @return LengthAwarePaginator<Series>
     */
    public function index(): LengthAwarePaginator
    {
        return Series::query()->paginate(10);
    }

    public function store(StoreRequest $request): Series
    {
        /** @var Series */
        return Series::query()->create([
            'title' => $request->title,
            'intro' => $request->intro,
            'description' => $request->description,
            'slug' => Str::slug($request->title),
        ]);
    }

    public function edit(Series $series): Series
    {
        $series->load('posts');
        return $series;
    }

    public function update(UpdateRequest $request, Series $series): void
    {
        $data = $request->collect()->forget('image');

        /** @var UploadedFile|null $image */
        $image = $request->file('image');

        $images = $this->savePhotoIfExist($image, $request->title, 'series');

        if ($images) {
            $data->put('image_xs', $images['xs']);
            $data->put('image_sm', $images['sm']);
            $data->put('image_lg', $images['lg']);
        }

        $data->put('slug', Str::slug($request->title));

        $series->update($data->toArray());

        if (!empty($request->posts)) {
            $series->posts()->sync($request->posts);
        }
    }

    public function destroy(Series $series): void
    {
        $series->delete();
    }
}
