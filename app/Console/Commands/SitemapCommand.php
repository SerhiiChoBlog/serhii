<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\PostContentImage;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapCommand extends Command
{
    protected $signature = 'make:sitemap';
    protected $description = 'Generate sitemap for the website';
    private string $site_url;

    public function __construct()
    {
        parent::__construct();
        $this->site_url = config('app.url');
    }

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

        $content = str_replace($this->site_url, 'https://serhii.io', $content);

        file_put_contents($path, $content);
    }

    /**
     * @return array<int, Url>
     */
    private function getPostsLinks(): array
    {
        return Post::query()
            ->with('images')
            ->select('id', 'title', 'image_lg', 'slug')
            ->where('is_published', true)
            ->get()
            ->map(function (Post $post) {
                $main_image = "$this->site_url/$post->image_lg";

                $url = Url::create(route('posts.show', $post->slug))
                    ->addImage($main_image, $post->title, '', $post->title);

                /** @var PostContentImage $image */
                foreach ($post->images as $image) {
                    $img_url = "$this->site_url$image->uri";
                    $url = $url->addImage($img_url);
                }

                return $url;
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
