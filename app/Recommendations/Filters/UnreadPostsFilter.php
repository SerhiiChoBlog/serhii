<?php

declare(strict_types=1);

namespace App\Recommendations\Filters;

use App\Models\Post;
use App\Utils\GlobalVisitor;
use Illuminate\Support\Collection;

final readonly class UnreadPostsFilter implements Filter
{
    /**
     * @inheritDoc
     */
    public function process(Collection $posts, int $limit): Collection
    {
        $visitor = GlobalVisitor::getInstance()->get();

        if (!$visitor) {
            return collect();
        }

        $viewed_posts = $visitor->postViews()->pluck('post_id');
        $lacking_posts_count = $limit - $posts->count();

        if ($lacking_posts_count > 0) {
            $lacking_posts = $this->getPosts($lacking_posts_count, $viewed_posts);
            $posts = $posts->merge($lacking_posts);
        }

        return $posts->filter(fn (Post $post) => !$viewed_posts->contains($post->id));
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
            ->limit($limit)
            ->get();
    }
}
