<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Visitor;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class DeleteRobotViews extends Command
{
    protected $signature = 'post:delete-robot-views';
    protected $description = 'Deletes post views from robots';

    public function handle(): int
    {
        /** @var Collection<int, Visitor> $bots */
        $bots = Visitor::query()->where('is_robot', true)->get();
        $views = 0;

        foreach ($bots as $bot) {
            $views += $bot->postViews()->count();
            $bot->postViews()->delete();
        }

        $this->info("Deleted views: {$views}");

        return Command::SUCCESS;
    }
}
