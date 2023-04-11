<?php

declare(strict_types=1);

namespace App\Recommendations\Filters;

use App\Models\Post;
use Illuminate\Support\Collection;

interface Filter
{
    public const POST_FIELDS = ['id', 'title', 'slug', 'image_sm'];
    public const SERIES_FIELDS = 'id,title';

    /**
     * @param Collection<int, Post> $posts
     * @param int $limit The maximum number of posts to return
     *
     * @return Collection<int, Post> Filtered posts
     */
    public function process(Collection $posts, int $limit): Collection;
}
