<?php

declare(strict_types=1);

namespace App\CommentModifiers;

use App\Services\Comment\CommentSanitizer;

readonly class SanitizeHtmlModifier implements CommentModifier
{
    public function __construct(private string $comment)
    {
    }

    public function modify(): string
    {
        return (new CommentSanitizer())->sanitize($this->comment);
    }
}
