<?php

declare(strict_types=1);

namespace App\Recommendations\Filters;

use App\Recommendations\DataStream;

final readonly class LikedPostsFilter implements Filter
{
    public function process(DataStream $stream): DataStream
    {
        $user = user();

        if (!$user) {
            return $stream;
        }

        $liked_posts_ids = $user->likedPosts()->pluck('post_id');

        $stream->exclude->push(...$liked_posts_ids);

        return $stream;
    }
}
