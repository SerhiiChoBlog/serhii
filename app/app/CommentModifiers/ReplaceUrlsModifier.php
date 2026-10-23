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
        $comment = preg_replace_callback(
            '/(https?:\/\/[^\s]*[^\s.,])/i',
            static function (array $matches): string {
                $url = htmlspecialchars($matches[1], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                return "<a href=\"{$url}\" target=\"_blank\">{$url}</a>";
            },
            $this->comment,
        );

        return $comment ?? $this->comment;
    }
}
