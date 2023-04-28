<?php

declare(strict_types=1);

namespace App\Listeners\Badges;

use App\Enums\BadgeName;
use App\Events\UserLikesPost;
use App\Models\Badge;
use App\Models\Feed;
use TypeError;

class CreateFeedForPostLike
{
    public function handle(UserLikesPost $event): void
    {
        $likes_count = $event->user->post_likes_count;
        $likes_count_type = gettype($likes_count);

        if ($likes_count_type !== 'integer') {
            throw new TypeError("likes_count must be an integer, got {$likes_count_type}");
        }

        Feed::givePostLikeFeedItem($event->user, $event->post_like);

        if ($likes_count >= Badge::POST_LIKES) {
            Feed::giveBadgeFeedItem($event->user, BadgeName::LOVELY);
        }
    }
}
