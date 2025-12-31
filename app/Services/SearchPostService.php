<?php

declare(strict_types=1);

namespace App\Services;

use App\CacheKey;
use App\Dto\SearchResult;
use Illuminate\Support\Facades\Cache;

readonly class SearchPostService
{
    public function __construct(private string $query)
    {
    }

    /**
     * @return array<int, SearchResult>
     */
    public function search(): array
    {
        $posts = Cache::rememberForever(
            CacheKey::POSTS_SEARCH,
            fn () => (new CachePostsService())->get()
        );

        return $this->findInArray($posts);
    }

    /**
     * @param array<int, SearchResult> $posts
     *
     * @return array<int, SearchResult>
     */
    private function findInArray(array $posts): array
    {
        $result = [];

        foreach ($posts as $post) {
            $match = $this->matchingPost($post);

            if ($match) {
                $result[] = $match;
            }
        }

        return $result;
    }

    private function matchingPost(SearchResult $post): SearchResult|null
    {
        $matches = str_contains(strtolower($post->title), $this->query)
            || $this->containsMatch($post->keywords);

        return $matches ? $post : null;
    }

    /**
     * @param array<int, string> $items
     */
    private function containsMatch(array $items): bool
    {
        foreach ($items as $item) {
            if (str_contains($item, $this->query)) {
                return true;
            }
        }

        return false;
    }
}
