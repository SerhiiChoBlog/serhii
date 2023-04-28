<?php

declare(strict_types=1);

namespace App\Listeners\Badges;

use App\Enums\BadgeName;
use App\Models\Feed;
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

        Feed::giveBadgeFeedItem($user, BadgeName::VERIFIED);
    }

    private function getUser(string $email): ?User
    {
        /** @var User|null */
        return User::query()
            ->select('id', 'email', 'name')
            ->where('email', $email)
            ->first();
    }
}
