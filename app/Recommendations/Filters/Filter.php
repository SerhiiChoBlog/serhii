<?php

declare(strict_types=1);

namespace App\Recommendations\Filters;

use App\Models\Post;
use Illuminate\Support\Collection;

interface Filter
{
    /**
     * @param Collection<int, Post> $posts
     *
     * @return Collection<int, Post>
     */
    public function process(Collection $posts): Collection;
}
