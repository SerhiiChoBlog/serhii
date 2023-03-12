<?php

declare(strict_types=1);

namespace App\CommentModifiers;

interface CommentModifier
{
    public function __construct(string $comment);

    public function modify(): string;
}
