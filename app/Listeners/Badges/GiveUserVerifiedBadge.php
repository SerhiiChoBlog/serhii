<?php

declare(strict_types=1);

namespace App\Listeners\Badges;

use App\Enums\BadgeName;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

class GiveUserVerifiedBadge
{
    public function handle(Verified $event): void
    {
        $email = $event->user->getEmailForVerification();

        $user = $this->getUser($email);

        if (!$user) {
            return;
        }

        $user->giveBadge(BadgeName::VERIFIED);

        $this->createFeedItem($user);
    }

    private function createFeedItem(User $user): void
    {
        /** @var Badge $badge */
        $badge = $user->badges()->where('name', BadgeName::VERIFIED)->firstOrFail();

        $user->giveBadgeFeedItem($badge);
    }

    private function getUser(string $email): ?User
    {
        /** @var User|null */
        return User::query()
            ->select('id', 'email')
            ->where('email', $email)
            ->first();
    }
}
