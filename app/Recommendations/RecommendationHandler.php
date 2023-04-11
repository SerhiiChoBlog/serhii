<?php

declare(strict_types=1);

namespace App\Recommendations;

use App\Models\Post;
use App\Recommendations\Filters\Filter;
use Illuminate\Support\Collection;

class RecommendationHandler
{
    public const POST_FIELDS = ['id', 'title', 'slug', 'image_sm'];

    /**
     * @var Collection<int, Post>
     */
    private Collection $posts;

    public function __construct(private readonly int $limit)
    {
        $this->posts = collect();
    }

    public function useFilter(Filter $filter): self
    {
        if ($this->posts->count() >= $this->limit) {
            return $this;
        }

        $this->posts = $filter->process($this->posts, $this->limit);

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function get(): Collection
    {
        $results_count = $this->posts->count();
        $lacking_posts_count = $this->limit - $results_count;

        if ($lacking_posts_count > 0) {
            $exclude_ids = $this->posts->pluck('id');
            $random_posts = $this->getRandomPosts($lacking_posts_count, $exclude_ids);
            return $this->posts->merge($random_posts);
        }

        if ($this->posts->count() > $this->limit) {
            return $this->posts->take($this->limit);
        }

        return $this->posts;
    }

    /**
     * @param Collection<int, int> $exclude_ids
     *
     * @return Collection<int, Post>
     */
    private function getRandomPosts(int $amount, Collection $exclude_ids): Collection
    {
        $result = Post::query()
            ->select(self::POST_FIELDS)
            ->where('is_published', true)
            ->whereNotIn('id', $exclude_ids->toArray())
            ->inRandomOrder()
            ->limit($amount)
            ->get();

        $missing_posts = $amount - $result->count();

        if ($missing_posts === 0) {
            return $result;
        }

        $additional_posts = Post::query()
            ->select(self::POST_FIELDS)
            ->where('is_published', true)
            ->inRandomOrder()
            ->limit($missing_posts)
            ->get();

        return $result->merge($additional_posts);
    }
}
