<?php

declare(strict_types=1);

namespace App\Listeners\Badges;

use App\Enums\BadgeName;
use App\Events\UserUnlikesPost;
use App\Models\Badge;
use App\Models\User;

class RemoveLovelyBadgeFromUser
{
    public function handle(UserUnlikesPost $event): void
    {
        if ($event->user->post_likes_count >= Badge::POST_LIKES) {
            return;
        }

        $this->removeUserBadge($event->user);
    }

    private function removeUserBadge(User $user): void
    {
        $badge_id = $user->badges()->where('name', BadgeName::LOVELY)->value('id');
        $user->badges()->detach($badge_id);
    }
}
