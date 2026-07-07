<?php

declare(strict_types=1);

namespace App\Recommendations;

use App\Models\Post;
use App\Recommendations\Filters\Filter;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class RecommendationSystem
{
    public const POST_FIELDS = [
        'id',
        'title',
        'intro',
        'slug',
        'image_sm',
        'image_xs',
        'created_at',
    ];

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
            ->with([
                'series' => function (BelongsToMany $q) {
                    return $q->select('id', 'title', 'slug')->withCount('posts');
                },
                'tags',
            ])
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
            ->with([
                'series' => function (BelongsToMany $q) {
                    return $q->select('id', 'title', 'slug')->withCount('posts');
                },
                'tags',
            ])
            ->select(self::POST_FIELDS)
            ->where('is_published', true)
            ->inRandomOrder()
            ->whereNotIn('id', $result->pluck('id'))
            ->limit($remaining_posts)
            ->get();

        return $result->push(...$additional_posts);
    }
}
