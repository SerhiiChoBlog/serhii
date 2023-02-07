<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class AddSecretToUsers extends Command
{
    protected $signature = 'users:secret';
    protected $description = 'Add secret to each user';

    public function handle(): int
    {
        /** @var Collection<int, User> $users */
        $users = User::all();

        $users->each(function (User $user) {
            $secret = User::generateSecret($user->email);
            $user->secret = $secret;
            $user->save();
        });

        $this->info("Secrets added to {$users->count()} users");

        return Command::SUCCESS;
    }
}
