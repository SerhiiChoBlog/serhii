<?php

declare(strict_types=1);

namespace App\Recommendations\Filters;

use App\Models\Post;
use App\Models\Series;
use App\Recommendations\DataStream;
use Illuminate\Support\Collection;

final readonly class PostSeriesFilter implements Filter
{
    public function __construct(private Post $post)
    {
    }

    public function process(DataStream $stream): DataStream
    {
        $series = $this->post->series()->select('id')->first();

        $stream->exclude->push($this->post->id);

        if ($series) {
            $posts = $this->getPostsFromSeries($series, $stream);

            $stream->exclude->push(...$posts->pluck('id'));
            $stream->posts->push(...$posts);
        }

        return $stream;
    }

    /**
     * @return Collection<int, Post>
     */
    private function getPostsFromSeries(Series $series, DataStream $stream): Collection
    {
        return $series->posts()
            ->select(self::POST_FIELDS)
            ->where('is_published', true)
            ->whereNotIn('id', $stream->exclude->toArray())
            ->get();
    }
}
