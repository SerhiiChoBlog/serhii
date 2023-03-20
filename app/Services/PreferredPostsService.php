<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Post;
use App\Utils\GlobalVisitor;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

readonly class PreferredPostsService
{
    private const LIMIT = 6;

    /**
     * @param array<int, int> $exclude
     *
     * @return Collection<int, Post>
     */
    public function get(array $exclude): Collection
    {
        $visitor = GlobalVisitor::getInstance()->get();

        if (!$visitor) {
            return $this->getRandomPosts($exclude, self::LIMIT);
        }

        $exclude_ids = $visitor->postViews()->pluck('post_id')->toArray();
        $exclude_ids = array_merge($exclude_ids, $exclude);

        $posts = $this->getRandomPosts($exclude_ids, self::LIMIT);

        if ($posts->count() === self::LIMIT) {
            return $posts;
        }

        $posts_missing = self::LIMIT - $posts->count();

        return $posts->push(...$this->getRandomPosts([], $posts_missing));
    }

    /**
     * @param array<int> $exclude
     *
     * @return Collection<int, Post>
     */
    private function getRandomPosts(array $exclude, int $limit): Collection
    {
        $query = Post::with('tags:name,color,title')
            ->with([
                'series' => function (BelongsToMany $q) {
                    return $q->select('id', 'title', 'slug')->withCount('posts');
                },
            ])
            ->select(Post::COMMON_FIELDS)
            ->where('is_published', true)
            ->inRandomOrder()
            ->limit($limit);

        if (count($exclude) > 0) {
            $query = $query->whereNotIn('id', $exclude);
        }

        return $query->get();
    }
}
