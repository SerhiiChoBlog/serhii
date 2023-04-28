<?php

declare(strict_types=1);

namespace App\Listeners\Badges;

use App\Enums\FeedType;
use App\Events\UserUnlikesPost;
use App\Models\Badge;

class RemoveFeedForPostLike
{
    public function handle(UserUnlikesPost $event): void
    {
        if ($event->user->post_likes_count >= Badge::POST_LIKES) {
            return;
        }

        $this->removeFeedItem($event);
    }

    private function removeFeedItem(UserUnlikesPost $event): void
    {
        $event->user
            ->feed()
            ->where('post_id', $event->post_id)
            ->where('type', FeedType::POST_LIKE)
            ->delete();
    }
}
