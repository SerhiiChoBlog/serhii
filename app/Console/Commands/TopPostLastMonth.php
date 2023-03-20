<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\CacheKey;
use App\Services\MonthlyTopCalculatorService;
use App\Ttl;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class TopPostLastMonth extends Command
{
    protected $signature = 'posts:top-last-month';
    protected $description = 'Calculates which post has the most views in the last month';

    public function handle(): int
    {
        $service = new MonthlyTopCalculatorService();
        $posts = $service->calculate(2);

        Cache::put(CacheKey::TOP_LAST_MONTH, $posts, Ttl::DAY);

        $this->info(count($posts) . ' posts has been saved as top last month');

        return Command::SUCCESS;
    }
}
