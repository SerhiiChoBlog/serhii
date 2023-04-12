<?php

declare(strict_types=1);

namespace App\Recommendations\Filters;

use App\Models\Post;
use App\Recommendations\DataStream;
use Illuminate\Support\Collection;

final readonly class LikedPostsFilter implements Filter
{
    public function process(DataStream $stream): DataStream
    {
        $user = auth()->user();

        if (!$user) {
            return $stream;
        }

        $liked_posts_ids = $user->likedPosts()->pluck('post_id');

        if ($stream->needsMoreContent()) {
            $lacking_posts = $this->getPosts($stream->remaining, $liked_posts_ids);
            $stream->posts->push(...$lacking_posts);
        }

        $stream->exclude->push(...$liked_posts_ids);

        return $stream;
    }

    /**
     * @param Collection<int, int> $viewed_posts_ids
     *
     * @return Collection<int, Post>
     */
    private function getPosts(int $limit, Collection $viewed_posts_ids): Collection
    {
        return Post::query()
            ->select(self::POST_FIELDS)
            ->whereNotIn('id', $viewed_posts_ids->toArray())
            ->where('is_published', true)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }
}
