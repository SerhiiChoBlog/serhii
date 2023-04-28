<?php

declare(strict_types=1);

namespace App\Listeners\Badges;

use App\Enums\BadgeName;
use App\Events\UserLikesPost;
use App\Models\Badge;
use App\Models\Feed;

class CreateFeedForPostLike
{
    public function handle(UserLikesPost $event): void
    {
        Feed::givePostLikeFeedItem($event->user, $event->post_like);

        if ($event->user->post_likes_count >= Badge::POST_LIKES) {
            Feed::giveBadgeFeedItem($event->user, BadgeName::LOVELY);
        }
    }
}
