<?php

declare(strict_types=1);

namespace App\Recommendations\Filters;

use App\Dto\RecommendationFilterResult;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Collection;

final class PostTagsFilter implements Filter
{
    /**
     * @var Collection<int, int>
     */
    private Collection $exclude_ids;

    public function __construct(private readonly Post $post)
    {
        $this->exclude_ids = collect([$post->id]);
    }

    /**
     * @inheritDoc
     */
    public function process(Collection $posts, int $limit): RecommendationFilterResult
    {
        $this->post->loadMissing('tags:id');

        $missing_posts = $limit - $posts->count();
        $new_posts = collect();

        foreach ($this->post->tags as $tag) {
            $similar_posts = $this->getTagPosts($tag, $missing_posts);

            $this->exclude_ids = $this->exclude_ids->merge($similar_posts->pluck('id'));

            $new_posts = $new_posts->merge($similar_posts);

            if ($new_posts->count() >= $missing_posts) {
                break;
            }
        }

        $posts = $posts->merge($new_posts);

        $exclude = collect([$this->post->id]);

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
            ->whereNotIn('id', $this->exclude_ids->toArray())
            ->limit($limit)
            ->get()
            ->shuffle();
    }
}
