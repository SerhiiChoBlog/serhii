<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetMainTagForTags extends Command
{
    protected $signature = 'tags:set-main';
    protected $description = 'Sets main tags in tags table';

    public function handle(): int
    {
        //

        return Command::SUCCESS;
    }
}
