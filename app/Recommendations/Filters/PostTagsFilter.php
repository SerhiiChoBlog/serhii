<?php

declare(strict_types=1);

namespace App\Recommendations\Filters;

use App\Dto\RecommendationFilterResult;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Collection;

final readonly class PostTagsFilter implements Filter
{
    public function __construct(private Post $post)
    {
    }

    /**
     * @inheritDoc
     */
    public function process(Collection $posts, int $limit): RecommendationFilterResult
    {
        $this->post->loadMissing('tags');

        $exclude = collect([$this->post]);

        foreach ($this->post->tags as $tag) {
            $posts = $posts->merge($this->getTagPosts($tag, $limit));

            if ($posts->count() >= $limit) {
                break;
            }
        }

        return new RecommendationFilterResult($posts, $exclude);
    }

    /**
     * @return Collection<int, Post>
     */
    private function getTagPosts(Tag $tag, int $limit): Collection
    {
        return $tag->posts()
            ->with('series:' . self::SERIES_FIELDS)
            ->select(self::POST_FIELDS)
            ->where('is_published', true)
            ->whereNot('id', $this->post->id)
            ->limit($limit)
            ->get()
            ->shuffle();
    }
}
