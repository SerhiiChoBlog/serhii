<?php

declare(strict_types=1);

namespace App\Recommendations\Filters;

use App\Dto\RecommendationFilterResult;
use App\Models\Post;
use App\Utils\GlobalVisitor;
use Illuminate\Support\Collection;

final readonly class ViewedPostsFilter implements Filter
{
    /**
     * @inheritDoc
     */
    public function process(Collection $posts, int $limit): RecommendationFilterResult
    {
        $visitor = GlobalVisitor::getInstance()->get();

        if (!$visitor) {
            return new RecommendationFilterResult();
        }

        $viewed_post_ids = $visitor->postViews()->pluck('post_id');

        $lacking_posts_count = $limit - $posts->count();

        if ($lacking_posts_count > 0) {
            $lacking_posts = $this->getPosts($lacking_posts_count, $viewed_post_ids);
            $posts = $posts->merge($lacking_posts);
        }

        $posts = $posts->filter(fn (Post $post) => !$viewed_post_ids->contains($post->id));

        return new RecommendationFilterResult($posts, $viewed_post_ids);
    }

    /**
     * @param Collection<int, int> $viewed_posts
     *
     * @return Collection<int, Post>
     */
    private function getPosts(int $limit, Collection $viewed_posts): Collection
    {
        return Post::query()
            ->select(self::POST_FIELDS)
            ->whereNotIn('id', $viewed_posts->toArray())
            ->where('is_published', true)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }
}
