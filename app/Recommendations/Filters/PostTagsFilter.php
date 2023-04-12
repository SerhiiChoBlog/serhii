<?php

declare(strict_types=1);

namespace App\Recommendations\Filters;

use App\Models\Post;
use App\Models\Tag;
use App\Recommendations\DataStream;
use Illuminate\Support\Collection;

final class PostTagsFilter implements Filter
{
    public function __construct(private readonly Post $post)
    {
    }

    public function process(DataStream $stream): DataStream
    {
        $stream->exclude->push($this->post->id);

        $tags = $this->post->tags()->select('id')->get();

        foreach ($tags as $tag) {
            $posts = $this->getTagPosts($tag, $stream);

            $stream->exclude->push(...$posts->pluck('id'));
            $stream->posts->push(...$posts);

            $stream->updateRemaining();

            if (!$stream->needsMoreContent()) {
                break;
            }
        }

        return $stream;
    }

    /**
     * @return Collection<int, Post>
     */
    private function getTagPosts(Tag $tag, DataStream $stream): Collection
    {
        return $tag->posts()
            ->with('series:' . self::SERIES_FIELDS)
            ->select(self::POST_FIELDS)
            ->where('is_published', true)
            ->whereNotIn('id', $stream->exclude->toArray())
            ->limit($stream->remaining)
            ->get()
            ->shuffle();
    }
}
