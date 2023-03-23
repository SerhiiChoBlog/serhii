<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\CachablePost;
use App\Models\Keyword;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Collection;

readonly class CachePostsService
{
    /**
     * @return array<int, CachablePost>
     */
    public function get(): array
    {
        $posts = $this->getPosts();

        $cachable_posts = $posts->map(function (Post $post) {
            $title = $post->title;

            if ($post->series && $post->series->isNotEmpty()) {
                $title = $post->series->first()->title . ': ' . $title;
            }

            return new CachablePost([
                'id' => $post->id,
                'title' => $title,
                'slug' => $post->slug,
                'image_xs' => $post->image_xs,
                'tags' => $post->tags->map(fn (Tag $t) => strtolower($t->name))->toArray(),
                'keywords' => $post->keywords->map(fn (Keyword $k) => strtolower($k->name))->toArray(),
            ]);
        });

        return $cachable_posts->toArray();
    }

    /**
     * @return Collection<int, Post>
     */
    private function getPosts(): Collection
    {
        return Post::with('tags', 'keywords', 'series')
            ->select('id', 'title', 'slug', 'image_xs')
            ->where('is_published', true)
            ->get();
    }
}
