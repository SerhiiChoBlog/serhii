<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Comment;
use App\Models\User;

readonly class StoreCommentService
{
    public function __construct(private User $user)
    {
    }

    public function handle(): Comment
    {
        //

        return new Comment();
    }
}
