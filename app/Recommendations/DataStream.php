<?php

declare(strict_types=1);

namespace App\Recommendations;

use App\Models\Post;
use Illuminate\Support\Collection;

class DataStream
{
    /**
     * @param Collection<int, Post> $items
     * @param Collection<int, int> $exclude
     */
    public function __construct(
        public Collection $items,
        public Collection $exclude,
        public int $remaining,
        public readonly int $limit,
    ) {
    }

    public function updateRemaining(): void
    {
        $this->remaining = $this->limit - $this->items->count();
    }

    public function needsMoreContent(): bool
    {
        return $this->remaining > 0;
    }
}
