<?php

declare(strict_types=1);

namespace App\Listeners\Badges;

use App\Enums\BadgeName;
use App\Events\UserLikesPost;
use App\Models\Feed;
use App\Models\User;

class GiveUserLovelyBadge
{
    public function handle(UserLikesPost $event): void
    {
        if ($this->userHasLikes($event->user, 10)) {
            $event->user->giveBadge(BadgeName::LOVELY);
            Feed::giveBadgeFeedItem($event->user, BadgeName::LOVELY);
        }
    }

    public function userHasLikes(User $user, int $amount): bool
    {
        return $user->postLikes()->count() >= $amount;
    }
}
