<?php

declare(strict_types=1);

namespace App\CommentModifiers;

use App\Models\Post;
use Illuminate\Support\Collection;

readonly class ReplaceLinksModifier implements CommentModifier
{
    public function __construct(private string $comment)
    {
    }

    public function modify(): string
    {
        /** @var Collection<int, Post> $posts */
        $posts = Post::query()->select('title', 'slug')->get('slug');

        $links = [];
        $replacements = [];

        foreach ($posts as $post) {
            $links[] = route('posts.show', $post->slug);
            $replacements[] = "<a href=\"/posts/{$post->slug}\">{$post->title}</a>";
        }

        return str_replace($links, $replacements, $this->comment);
    }
}
