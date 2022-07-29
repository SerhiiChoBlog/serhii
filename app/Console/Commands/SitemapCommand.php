<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

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
            ->add($this->getTaggedPosts())
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
            ->select('id', 'title', 'image_lg', 'slug')
            ->where('is_published', true)
            ->get()
            ->map(function (Post $post) {
                $img = config('app.url') . '/' . $post->image_lg;

                // todo: images are not generated
                return Url::create(route('posts.show', $post->slug))
                    ->addImage($img, $post->title, '', $post->title);
            });
    }

    /**
     * @return Collection<int, string>
     */
    private function getProjectsLinks(): Collection
    {
        return Project::query()
            ->pluck('name')
            ->map(fn(string $name) => Url::create(route('projects.show', $name)));
    }

    /**
     * @return Collection<int, string>
     */
    private function getTaggedPosts(): Collection
    {
        return Tag::query()
            ->has('posts')
            ->pluck('name')
            ->map(fn(string $tag) => Url::create(route('posts.index', ['tag' => $tag])));
    }

    private function getImages(): Collection
    {
        return collect();
    }
}
