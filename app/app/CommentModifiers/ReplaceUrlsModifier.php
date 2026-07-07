<?php

declare(strict_types=1);

namespace App\CommentModifiers;

/**
 * Replaces text URLs to HTML links that you can click.
 */
readonly class ReplaceUrlsModifier implements CommentModifier
{
    public function __construct(private string $comment)
    {
    }

    public function modify(): string
    {
        // replace all urls with html links
        $comment = preg_replace(
            '/(https?:\/\/[^\s]*[^\s.,])/i',
            '<a href="$1" target="_blank">$1</a>',
            $this->comment,
        );

        return $comment ?? $this->comment;
    }
}
