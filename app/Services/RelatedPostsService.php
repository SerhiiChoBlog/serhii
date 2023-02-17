<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Collection;

readonly class RelatedPostsService
{
    private const POSTS_LIMIT = 3;

    public function __construct(private Post $post)
    {
    }

    /**
     * @return Collection<int, Post>
     */
    public function get(): Collection
    {
        if ($this->post->tags->isEmpty()) {
            return $this->getRandomPosts(self::POSTS_LIMIT);
        }

        /** @var Tag|null $main_tag */
        $main_tag = $this->post->tags->firstWhere('pivot.is_main', true);

        /** @var Collection<int, Tag> $other_tags */
        $other_tags = $this->post->tags->where('pivot.is_main', false);

        if ($main_tag === null) {
            /** @var Tag|null $main_tag */
            $main_tag = $other_tags->first();
        }

        if ($main_tag === null) {
            return $this->getRandomPosts(self::POSTS_LIMIT);
        }

        $posts = $this->getTagPosts($main_tag, self::POSTS_LIMIT);

        if ($posts->count() === self::POSTS_LIMIT) {
            return $posts;
        }

        $add_posts_diff = self::POSTS_LIMIT - $posts->count();
        $other_posts = $this->getOtherPosts($other_tags, $add_posts_diff);

        if ($other_posts->count() > 0) {
            $posts->push(...$other_posts);
        }

        $random_posts = $this->getRandomPosts(self::POSTS_LIMIT - $posts->count());

        $posts->push(...$random_posts);

        return $posts;
    }

    /**
     * @return Collection<int, Post>
     */
    private function getRandomPosts(int $limit): Collection
    {
        return Post::query()
            ->select('id', 'slug', 'title', 'image_sm')
            ->where('is_published', true)
            ->where('id', '!=', $this->post->id)
            ->inRandomOrder()
            ->limit($limit)
            ->get()
            ->shuffle();
    }

    /**
     * @return Collection<int, Post>
     */
    private function getTagPosts(Tag $main_tag, int $limit): Collection
    {
        return $main_tag->posts()
            ->select('id', 'slug', 'title', 'image_sm')
            ->where('is_published', true)
            ->where('id', '!=', $this->post->id)
            ->limit($limit)
            ->get()
            ->shuffle();
    }

    /**
     * @param Collection<int, Tag> $tags
     *
     * @return Collection<int, Post>
     */
    private function getOtherPosts(Collection $tags, int $limit): Collection
    {
        $result = collect([]);

        foreach ($tags as $tag) {
            $result->push(...$this->getTagPosts($tag, $limit));
            $posts_found = $result->count();

            if ($posts_found === $limit) {
                return $result;
            }

            $limit -= $posts_found;
        }

        return $result;
    }
}
