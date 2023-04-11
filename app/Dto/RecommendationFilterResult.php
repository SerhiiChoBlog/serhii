<?php

declare(strict_types=1);

namespace App\Dto;

use App\Models\Post;
use Illuminate\Support\Collection;

readonly class RecommendationFilterResult
{
    /**
     * @param Collection<int, Post>|null $posts
     * @param Collection<int, Post>|null $exclude
     */
    public function __construct(
        public ?Collection $posts = null,
        public ?Collection $exclude = null,
    ) {
    }
}
