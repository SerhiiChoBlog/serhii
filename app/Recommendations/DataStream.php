<?php

declare(strict_types=1);

namespace App\Recommendations;

use App\Models\Post;
use Illuminate\Support\Collection;

class DataStream
{
    /**
     * @param Collection<int, Post> $posts
     * @param Collection<int, int> $exclude
     */
    public function __construct(
        public Collection $posts,
        public Collection $exclude,
        public int $remaining,
        public readonly int $limit,
    ) {
    }

    public function updateRemaining(): void
    {
        $this->remaining = $this->limit - $this->posts->count();
    }

    public function needsMoreContent(): bool
    {
        return $this->remaining > 0;
    }
}
