<?php

declare(strict_types=1);

use App\Console\Commands\DeleteRobotViews;
use App\Console\Commands\DetectRobotsVisitors;
use App\Console\Commands\FetchGithubProjects;
use App\Console\Commands\FetchVideos;
use App\Console\Commands\SitemapCommand;
use App\Console\Commands\SubscriptionsNotify;
use App\Console\Commands\TopPostLastMonth;
use Illuminate\Support\Facades\Schedule;

Schedule::command(SubscriptionsNotify::class)->hourly();
Schedule::command(FetchGithubProjects::class)->dailyAt('00:01');
Schedule::command(FetchVideos::class)->dailyAt('00:02');
Schedule::command(DetectRobotsVisitors::class)->dailyAt('00:03');
Schedule::command(DeleteRobotViews::class)->dailyAt('00:04');
Schedule::command(TopPostLastMonth::class)->dailyAt('00:05');
Schedule::command(SitemapCommand::class)->dailyAt('00:06');

Schedule::command('queue:work --tries=2 --stop-when-empty -n')
    ->everyMinute()
    ->withoutOverlapping();

Schedule::command('queue:retry all')->daily();

Schedule::command('cache:clear')->monthlyOn(1, '00:07');
