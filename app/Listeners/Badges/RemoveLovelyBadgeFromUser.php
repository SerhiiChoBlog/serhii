<?php

declare(strict_types=1);

namespace App\Listeners\Badges;

use App\Enums\BadgeName;
use App\Events\UserUnlikesPost;
use App\Models\User;

class RemoveLovelyBadgeFromUser
{
    public function handle(UserUnlikesPost $event): void
    {
        if ($this->userHasLikesBelow($event->user, 10)) {
            $id = $event->user->badges()->where('name', BadgeName::LOVELY)->value('id');
            $event->user->badges()->detach($id);
        }
    }

    public function userHasLikesBelow(User $user, int $amount): bool
    {
        return $user->postLikes()->count() < $amount;
    }
}
