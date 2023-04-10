<?php

declare(strict_types=1);

namespace App\Recommendations;

use App\Models\Post;
use App\Recommendations\Filters\Filter;
use Illuminate\Support\Collection;

class RecommendationHandler
{
    /**
     * @var Collection<int, Post>
     */
    private readonly Collection $posts;

    /**
     * @var Collection<int, Post>
     */
    private Collection $filtered_posts;

    /**
     * @param Collection<int, Post> $posts
     */
    public function __construct(Collection $posts, private readonly int $limit)
    {
        $this->posts = $posts;
        $this->filtered_posts = $posts;
    }

    public function useFilter(Filter $filter): self
    {
        $this->filtered_posts = $filter->process($this->filtered_posts);
        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function get(): Collection
    {
        $results_count = $this->filtered_posts->count();

        if ($results_count < $this->limit) {
            $random_posts = $this->getRandomPosts($this->limit - $results_count);
            return $this->filtered_posts->push(...$random_posts);
        }

        return $this->filtered_posts->take($this->limit);
    }

    /**
     * @return array<int, Post>
     */
    private function getRandomPosts(int $amount): array
    {
        $excluded_ids = $this->filtered_posts->pluck('id');

        $result = [];

        foreach ($this->posts->shuffle() as $post) {
            if ($excluded_ids->contains($post->id)) {
                continue;
            }

            $result[] = $post;

            if (count($result) >= $amount) {
                break;
            }
        }

        return $result;
    }
}
