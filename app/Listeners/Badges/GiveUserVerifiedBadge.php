<?php

namespace App\Listeners\Badges;

use App\Enums\BadgeName;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

class GiveUserVerifiedBadge
{
    public function handle(Verified $event): void
    {
        $email = $event->user->getEmailForVerification();

        $user = $this->getUser($email);
        $user?->giveBadge(BadgeName::VERIFIED);
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
