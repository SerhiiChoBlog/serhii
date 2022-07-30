<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapCommand extends Command
{
    protected $signature = 'make:sitemap';
    protected $description = 'Generate sitemap for the website';

    public function handle(): void
    {
        $path = public_path('sitemap.xml');

        $result = Sitemap::create()
            ->add($this->getPostsLinks())
            ->add($this->getProjectsLinks())
            ->add($this->getTaggedPosts())
            ->writeToFile($path);

        $tags_count = count($result->getTags());

        $this->replaceSiteUrl($path);

        $this->info("Sitemap is generated with <fg=yellow>$tags_count</> tags.");
    }

    private function replaceSiteUrl(string $path): void
    {
        $content = file_get_contents($path);

        if (!$content) {
            return;
        }

        $content = str_replace(config('app.url'), 'https://serhii.io', $content);

        file_put_contents($path, $content);
    }

    /**
     * @return array<int, Url>
     */
    private function getPostsLinks(): array
    {
        return Post::query()
            ->select('id', 'title', 'image_lg', 'slug')
            ->where('is_published', true)
            ->get()
            ->map(function (Post $post) {
                $img = config('app.url') . '/' . $post->image_lg;

                return Url::create(route('posts.show', $post->slug))
                    ->addImage($img, $post->title, '', $post->title);
            })
            ->toArray();
    }

    /**
     * @return array<int, Url>
     */
    private function getProjectsLinks(): array
    {
        return Project::query()
            ->pluck('name')
            ->map(fn(string $name) => Url::create(route('projects.show', $name)))
            ->toArray();
    }

    /**
     * @return array<int, Url>
     */
    private function getTaggedPosts(): array
    {
        return Tag::query()
            ->has('posts')
            ->pluck('name')
            ->map(fn(string $tag) => Url::create(route('posts.index', ['tag' => $tag])))
            ->toArray();
    }
}
