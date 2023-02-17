<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Hit;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class SetTimeToZerosInHitsTable extends Command
{
    protected $signature = 'hits:reset-time';
    protected $description = 'Set created_at column with 00:00:00 time in hits table';

    public function handle(): int
    {
        /** @var Collection<int, Hit> $hits */
        $hits = Hit::query()->get();

        $unique = $hits->unique('created_at');
        $duplicate = $hits->diff($unique);

        $bar = $this->output->createProgressBar($hits->count());

        foreach ($hits as $hit) {
            $hit->created_at = $hit->created_at->setTime(0, 0);
            $hit->save();

            $bar->advance();
        }

        $bar->finish();

        $this->info("\nDone!");
        $this->info("There are {$duplicate->count()} duplicates in table");

        return Command::SUCCESS;
    }
}
