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
     * @var array<int, int>
     */
    private array $exclude = [];

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

    public function exclude(int $post_id): self
    {
        $this->exclude[] = $post_id;
        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function get(): Collection
    {
        $this->filtered_posts = $this->filtered_posts
            ->reject(fn (Post $post) => in_array($post->id, $this->exclude, true));


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
        $excluded_ids = $this->filtered_posts->pluck('id')->merge($this->exclude);

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
