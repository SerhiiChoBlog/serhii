<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\BadgeName;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Console\Command;

class AddPreviousFeedToUsers extends Command
{
    protected $signature = 'users:add-feed';
    protected $description = 'Add previous feed to users like registration event, comments and likes';

    public function handle(): int
    {
        $processed = 0;

        $users = User::all();

        foreach ($users as $user) {
            /** @var Badge $badge */
            $badge = Badge::query()->where('name', BadgeName::VERIFIED)->firstOrFail();

            $user->giveBadgeFeedItem($badge);

            $processed++;
        }

        $this->info("Processed {$processed} users");

        return Command::SUCCESS;
    }
}
