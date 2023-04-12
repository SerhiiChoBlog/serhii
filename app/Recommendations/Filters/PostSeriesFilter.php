<?php

declare(strict_types=1);

namespace App\Recommendations\Filters;

use App\Dto\RecommendationFilterResult;
use App\Models\Post;
use App\Models\Series;
use Illuminate\Support\Collection;

final readonly class PostSeriesFilter implements Filter
{
    public function __construct(private Post $post)
    {
    }

    /**
     * @inheritDoc
     */
    public function process(Collection $posts, int $limit): RecommendationFilterResult
    {
        $this->post->loadMissing('series');

        $series = $this->post->series->first();
        $exclude = collect([$this->post->id]);

        if (!$series) {
            return new RecommendationFilterResult($posts, $exclude);
        }

        $posts = $this->getPostsFromSeries($series);

        return new RecommendationFilterResult($posts, $exclude);
    }

    /**
     * @return Collection<int, Post>
     */
    private function getPostsFromSeries(Series $series): Collection
    {
        return $series->posts()
            ->select(self::POST_FIELDS)
            ->where('is_published', true)
            ->whereNot('id', $this->post->id)
            ->get();
    }
}
