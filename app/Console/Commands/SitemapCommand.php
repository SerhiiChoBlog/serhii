<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Spatie\Sitemap\SitemapGenerator;

class SitemapCommand extends Command
{
    protected $signature = 'make:sitemap';
    protected $description = 'Generate sitemap for the website';

    public function handle(): void
    {
        $path = public_path('sitemap.xml');

        SitemapGenerator::create(config('app.url'))
            ->getSitemap()
            ->add($this->getPostsLinks())
            ->add($this->getProjectsLinks())
            ->writeToFile($path);

        $this->replaceSiteUrl($path);

        $this->info('Sitemap is generated:');
        $this->comment($path);
    }

    private function replaceSiteUrl(string $path): void
    {
        $content = file_get_contents($path);

        $content = str_replace(config('app.url'), 'https://serhii.io', $content);

        file_put_contents($path, $content);
    }

    /**
     * @return Collection<int, string>
     */
    private function getPostsLinks(): Collection
    {
        return Post::query()
            ->where('is_published', true)
            ->pluck('slug')
            ->map(fn(string $slug) => route('posts.show', $slug));
    }

    /**
     * @return Collection<int, string>
     */
    private function getProjectsLinks(): Collection
    {
        return Project::query()
            ->pluck('name')
            ->map(fn(string $name) => route('projects.show', $name));
    }
}
