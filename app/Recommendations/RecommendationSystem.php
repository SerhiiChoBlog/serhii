<?php

declare(strict_types=1);

namespace App\Recommendations;

use App\Models\Post;
use App\Recommendations\Filters\Filter;
use Illuminate\Support\Collection;

class RecommendationSystem
{
    public const POST_FIELDS = ['id', 'title', 'slug', 'image_sm'];

    private DataStream $stream;

    public function __construct(int $limit)
    {
        $this->stream = new DataStream(
            items: new Collection(),
            exclude: new Collection(),
            remaining: $limit,
            limit: $limit,
        );
    }

    public function pipe(Filter $filter): self
    {
        $this->stream->updateRemaining();

        if ($this->stream->needsMoreContent()) {
            $this->stream = $filter->process($this->stream);
        }

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function get(): Collection
    {
        $this->stream->updateRemaining();

        if ($this->stream->needsMoreContent()) {
            $random_posts = $this->getRandomPosts();
            return $this->stream->items->merge($random_posts);
        }

        return $this->stream->items->take($this->stream->limit);
    }

    /**
     * @return Collection<int, Post>
     */
    private function getRandomPosts(): Collection
    {
        $result = Post::query()
            ->select(self::POST_FIELDS)
            ->where('is_published', true)
            ->whereNotIn('id', $this->stream->exclude)
            ->inRandomOrder()
            ->limit($this->stream->remaining)
            ->get();

        $remaining_posts = $this->stream->remaining - $result->count();

        if ($remaining_posts === 0) {
            return $result;
        }

        $additional_posts = Post::query()
            ->select(self::POST_FIELDS)
            ->where('is_published', true)
            ->inRandomOrder()
            ->whereNotIn('id', $result->pluck('id'))
            ->limit($remaining_posts)
            ->get();

        return $result->push(...$additional_posts);
    }
}
