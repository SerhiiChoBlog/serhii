<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class SitemapCommand extends Command
{
    protected $signature = 'make:sitemap';
    protected $description = 'Generate sitemap for the website';

    public function handle(): void
    {
        $path = public_path('sitemap.xml');

        SitemapGenerator::create(config('app.url'))
            ->writeToFile($path);

        $this->replaceSiteUrl($path);
    }

    public function replaceSiteUrl(string $path): void
    {
        $content = file_get_contents($path);

        $content = str_replace(config('app.url'), 'https://serhii.io', $content);

        file_put_contents($path, $content);
    }
}
