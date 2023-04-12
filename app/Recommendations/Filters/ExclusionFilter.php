<?php

declare(strict_types=1);

namespace App\Recommendations\Filters;

use App\Recommendations\DataStream;
use Illuminate\Support\Collection;

final readonly class ExclusionFilter implements Filter
{
    /**
     * @param Collection<int, int> $exclude_ids
     */
    public function __construct(private Collection $exclude_ids)
    {
    }

    public function process(DataStream $stream): DataStream
    {
        $stream->exclude->push(...$this->exclude_ids);
        return $stream;
    }
}
