<?php

declare(strict_types=1);

namespace App\Listeners\Badges;

use App\Enums\BadgeName;
use App\Events\UserLikesPost;
use App\Models\Badge;

class GiveUserLovelyBadge
{
    public function handle(UserLikesPost $event): void
    {
        if ($event->user->post_likes_count >= Badge::POST_LIKES) {
            $event->user->giveBadge(BadgeName::LOVELY);
        }
    }
}
