<?php

declare(strict_types=1);

namespace App\CommentModifiers;

readonly class StripTagsModifier implements CommentModifier
{
    public const EXCLUDE_TAGS_FROM_STRIPING = [
        'a',
    ];

    public function __construct(private string $comment)
    {
    }

    public function modify(): string
    {
        return strip_tags($this->comment, self::EXCLUDE_TAGS_FROM_STRIPING);
    }
}
