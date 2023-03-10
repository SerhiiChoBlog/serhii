<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Visitor;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class CalculateGoogleIpAddresses extends Command
{
    protected $signature = 'visitors:google-ips';
    protected $description = 'Calculate Google Crawler IP addresses in visitors table';

    public function handle(): int
    {
        /** @var Collection<int, Visitor> $visitors */
        $visitors = Visitor::query()
            ->select('id', 'ip', 'country', 'city')
            ->withCount('postViews')
            ->get();

        $ranges = Visitor::getGoogleCrawlersIpsMatches();

        $visitors = $visitors->filter(function (Visitor $visitor) use ($ranges) {
            $long_ip = ip2long($visitor->ip);

            if (!$long_ip) {
                return false;
            }

            return $ranges->contains(fn (array $range) => $long_ip >= $range[0] && $long_ip <= $range[1]);
        });

        $posts_count = Post::query()->where('is_published', true)->count();

        $this->info(sprintf("Google Crawlers: <fg=yellow>%d</>", $visitors->count()));
        $this->info(sprintf("Countries: <fg=yellow>%s</>", $visitors->pluck('country')->unique()->join(', ')));
        $this->info(sprintf("Cities: <fg=yellow>%s</>", $visitors->pluck('city')->unique()->join(', ')));

        $this->info(
            sprintf(
                "Post views: <fg=yellow>%d</> (<fg=yellow>%d</> per post)",
                $visitors->sum('post_views_count'),
                round($visitors->sum('post_views_count') / $posts_count),
            )
        );

        return Command::SUCCESS;
    }
}
