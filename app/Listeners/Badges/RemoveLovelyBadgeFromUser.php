<?php

declare(strict_types=1);

namespace App\Listeners\Badges;

use App\Enums\BadgeName;
use App\Enums\FeedType;
use App\Events\UserUnlikesPost;
use App\Models\Badge;
use App\Models\User;

class RemoveLovelyBadgeFromUser
{
    public function handle(UserUnlikesPost $event): void
    {
        if ($event->user->postLikes()->count() >= Badge::POST_LIKES) {
            return;
        }

        $this->removeUserBadge($event->user);
        $this->removeFeedItem($event);
    }

    private function removeUserBadge(User $user): void
    {
        $badge_id = $user->badges()->where('name', BadgeName::LOVELY)->value('id');
        $user->badges()->detach($badge_id);
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
