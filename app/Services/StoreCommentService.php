<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Comment;

class StoreCommentService
{
    public function __construct(private string $name)
    {
    }

    public function handle(): Comment
    {
        $avatar = $this->generateAvatar();

        return new Comment();
    }
}
