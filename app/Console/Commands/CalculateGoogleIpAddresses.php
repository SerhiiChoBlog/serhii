<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Visitor;
use Illuminate\Console\Command;

class CalculateGoogleIpAddresses extends Command
{
    protected $signature = 'visitors:google-ips';
    protected $description = 'Calculate Google Crawler IP addresses in visitors table';

    public function handle(): int
    {
        $bots = Visitor::getRobots();
        $posts_count = Post::query()->where('is_published', true)->count();

        $this->info(sprintf("Google Crawlers: <fg=yellow>%d</>", $bots->count()));
        $this->info(sprintf("Countries: <fg=yellow>%s</>", $bots->pluck('country')->unique()->join(', ')));
        $this->info(sprintf("Cities: <fg=yellow>%s</>", $bots->pluck('city')->unique()->join(', ')));

        $this->info(
            sprintf(
                "Post views: <fg=yellow>%d</> (<fg=yellow>%d</> per post)",
                $bots->sum('post_views_count'),
                round($bots->sum('post_views_count') / $posts_count),
            )
        );

        return Command::SUCCESS;
    }
}
