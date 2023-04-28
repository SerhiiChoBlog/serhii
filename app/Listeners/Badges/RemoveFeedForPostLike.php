<?php

declare(strict_types=1);

namespace App\Listeners\Badges;

use App\Enums\FeedType;
use App\Events\UserUnlikesPost;
use App\Models\Badge;
use TypeError;

class RemoveFeedForPostLike
{
    public function handle(UserUnlikesPost $event): void
    {
        $likes_count = $event->user->post_likes_count;
        $likes_count_type = gettype($likes_count);

        if ($likes_count_type !== 'integer') {
            throw new TypeError("likes_count must be an integer, got {$likes_count_type}");
        }

        if ($likes_count >= Badge::POST_LIKES) {
            return;
        }

        $event->user
            ->feed()
            ->where('post_id', $event->post_id)
            ->where('type', FeedType::POST_LIKE)
            ->delete();
    }
}
