<?php

declare(strict_types=1);

namespace App\Recommendations\Filters;

use App\Dto\RecommendationFilterResult;
use Illuminate\Support\Collection;

final readonly class ExclusionFilter implements Filter
{
    /**
     * @param Collection<int, int> $exclude_ids
     */
    public function __construct(private Collection $exclude_ids)
    {
    }

    /**
     * @inheritDoc
     */
    public function process(Collection $posts, int $limit): RecommendationFilterResult
    {
        return new RecommendationFilterResult($posts, $this->exclude_ids);
    }
}
