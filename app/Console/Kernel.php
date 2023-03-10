<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\DetectRobotsVisitors;
use App\Console\Commands\FetchGithubProjects;
use App\Console\Commands\FetchVideos;
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
        SubscriptionsNotify::class,
        FetchVideos::class,
        DetectRobotsVisitors::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(SubscriptionsNotify::class)->hourly();
        $schedule->command(FetchGithubProjects::class)->dailyAt('00:01');
        $schedule->command(FetchVideos::class)->dailyAt('00:02');
        $schedule->command(DetectRobotsVisitors::class)->dailyAt('00:03');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
