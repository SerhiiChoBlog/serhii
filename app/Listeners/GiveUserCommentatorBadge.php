<?php

namespace App\Listeners;

use App\Enums\BadgeName;
use App\Events\CommentApproved;
use App\Models\User;

class GiveUserCommentatorBadge
{
    public function handle(CommentApproved $event): void
    {
        if ($this->userHasComments($event->user, 5)) {
            $event->user->giveBadge(BadgeName::COMMENTATOR);
        }
    }

    public function userHasComments(User $user, int $amount): bool
    {
        return $user->comments()->count() >= $amount;
    }
}
