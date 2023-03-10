<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Visitor;
use Illuminate\Console\Command;

class DetectRobotsVisitors extends Command
{
    protected $signature = 'visitors:detect-robots';
    protected $description = 'Marks robots in visitors table as robots';

    public function handle(): int
    {
        $bots = Visitor::getRobots();

        $bots->each(function ($bot) {
            if ($bot->is_robot) {
                return;
            }

            $bot->is_robot = true;
            $bot->save();
        });

        $this->info("Robots: {$bots->count()}");
        $this->newLine();

        return Command::SUCCESS;
    }
}
