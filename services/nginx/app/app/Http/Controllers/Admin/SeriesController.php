<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Series\StoreRequest;
use App\Http\Requests\Admin\Series\UpdateRequest;
use App\Models\Series;
use App\Utils\ImageProcessor;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SeriesController extends Controller
{
    public const TEMPORARY_DESCRIPTION = 'To be continued...';

    /**
     * @return array{
     *     series: LengthAwarePaginator<int, Series>,
     *     total: int,
     * }
     */
    public function index(): array
    {
        return [
            'total' => Series::query()->count(),
            'series' => Series::with('posts')->orderByDesc('created_at')->paginate(10),
        ];
    }

    /**
     * @return Collection<int, Series>
     */
    public function names(): Collection
    {
        /** @var Collection<int, Series> */
        return Series::query()
            ->select('id', 'title')
            ->latest()
            ->limit(50)
            ->get();
    }

    public function store(StoreRequest $request): Series
    {
        /** @var Series */
        return Series::query()->create([
            'title' => $request->title,
            'intro' => $request->intro,
            'description' => self::TEMPORARY_DESCRIPTION,
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
        $data = $request->collect()->forget(['image', '_method']);

        /** @var UploadedFile|null $image */
        $image = $request->file('image');

        $image_processor = new ImageProcessor($image, [
            'xs' => [100, 25],
            'sm' => [800, 200],
            'lg' => [1600, 400],
        ]);

        $images = $image_processor->save($request->title, 'series');

        if ($images) {
            $data->put('image_xs', $images['xs']);
            $data->put('image_sm', $images['sm']);
            $data->put('image_lg', $images['lg']);
        }

        $data->put('slug', Str::slug($request->title));

        $series->update($data->toArray());
        $series->posts()->sync($this->addPartsToPosts($request->posts ?? []));
    }

    public function destroy(Series $series): void
    {
        $series->delete();
    }

    /**
     * @param list<int> $posts
     *
     * @return array<int, array{part: int}>
     */
    private function addPartsToPosts(array $posts): array
    {
        $result = [];

        foreach ($posts as $key => $post_id) {
            $result[$post_id] = ['part' => $key + 1];
        }

        return $result;
    }
}
