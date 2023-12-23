<?php

declare(strict_types=1);

namespace App\CommentModifiers;

readonly class NewLineModifier implements CommentModifier
{
    public function __construct(private string $comment)
    {
    }

    public function modify(): string
    {
        $result = str_replace("\n", '<br>', $this->comment);

        // replace all multiple <br> tags with 2 <br> tag
        $result = preg_replace('/(<br\s*\/?>\s*){2,}/', '<br><br>', $result);

        return is_string($result) ? $result : $this->comment;
    }
}
