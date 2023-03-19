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
        $result = collect();

        if ($this->post->series->isNotEmpty()) {
            $result->push(...$this->getSeriesPosts());
        }

        if ($result->count() === self::POSTS_LIMIT) {
            return $result;
        }

        /** @var Tag|null $main_tag */
        $main_tag = $this->post->tags->firstWhere('pivot.is_main', true);
        $other_tags = $this->post->tags->where('pivot.is_main', false);

        if ($main_tag === null) {
            $main_tag = $other_tags->first();
        }

        $new_limit = self::POSTS_LIMIT - $result->count();

        if ($main_tag === null) {
            $result->push(...$this->getRandomPosts($new_limit, [$this->post->id]));
            return $result;
        }

        $result->push(...$this->getTagPosts($main_tag, $new_limit));

        if ($result->count() === self::POSTS_LIMIT) {
            return $result;
        }

        $new_limit = self::POSTS_LIMIT - $result->count();
        $result->push(...$this->getOtherPosts($other_tags, $new_limit));

        if ($result->count() === self::POSTS_LIMIT) {
            return $result;
        }

        $new_limit = self::POSTS_LIMIT - $result->count();

        $random_posts = $this->getRandomPosts(
            $new_limit,
            [$this->post->id, ...$result->pluck('id')->toArray()],
        );

        return $result->push(...$random_posts);
    }

    /**
     * @params array<int, int> $exclude
     *
     * @return Collection<int, Post>
     */
    private function getRandomPosts(int $limit, array $exclude): Collection
    {
        return Post::query()
            ->select('id', 'slug', 'title', 'image_sm')
            ->where('is_published', true)
            ->whereNotIn('id', $exclude)
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

    /**
     * @return Collection<int, Post>
     */
    private function getSeriesPosts(): Collection
    {
        $series = $this->post->series->first();

        if (!$series) {
            return collect();
        }

        return $series->posts->slice(0, self::POSTS_LIMIT);
    }
}
