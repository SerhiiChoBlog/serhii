<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

class ConnectSubscriptionToUser
{
    public function handle(Verified $event): void
    {
        $email = $event->user->getEmailForVerification();
        $user = $this->getUser($email);

        if (!$user) {
            return;
        }

        Subscription::query()
            ->select('id', 'email')
            ->where('email', $email)
            ->update(['user_id' => $user->id]);
    }

    private function getUser(string $email): User|null
    {
        /** @var User|null */
        return User::query()
            ->select('id', 'email')
            ->where('email', $email)
            ->first();
    }
}
