<?php

declare(strict_types=1);

namespace App\CommentModifiers;

use App\Models\Post;
use Illuminate\Support\Collection;

/**
 * Replaces text URLs to my posts with HTML links.
 */
readonly class ReplacePostUrlsModifier implements CommentModifier
{
    public function __construct(private string $comment)
    {
    }

    public function modify(): string
    {
        $app_url = config('app.url');

        if (!str_contains($this->comment, $app_url)) {
            return $this->comment;
        }

        /** @var Collection<int, Post> $posts */
        $posts = Post::query()
            ->select('title', 'slug')
            ->where('is_published', true)
            ->get()
            ->sortByDesc(fn (Post $post): int => strlen($post->slug))
            ->values();

        if ($posts->isEmpty()) {
            return $this->comment;
        }

        /** @var Collection<string, string> $titles */
        $titles = $posts->pluck('title', 'slug');

        $slugs = $titles->keys()
            ->map(fn (string $slug): string => preg_quote($slug, '#'))
            ->implode('|');

        $pattern = '#' . preg_quote($app_url, '#') . '/posts/(' . $slugs . ')#';

        return preg_replace_callback($pattern, function (array $matches) use ($titles): string {
            $slug = $matches[1];
            $title = e($titles->get($slug));
            $href = e($slug);

            return "<a href=\"/posts/{$href}\">{$title}</a>";
        }, $this->comment) ?? $this->comment;
    }
}
