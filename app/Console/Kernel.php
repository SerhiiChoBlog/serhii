<?php

namespace App\Console;

use App\Console\Commands\FetchGithubProjects;
use App\Console\Commands\SubscriptionsNotify;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array<int, string>
     */
    protected $commands = [
        FetchGithubProjects::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(FetchGithubProjects::class)->daily();
        $schedule->command(SubscriptionsNotify::class)->hourly();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
