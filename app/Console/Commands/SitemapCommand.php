<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\PostContentImage;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
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
            ->add($this->aboutMe())
            ->add($this->posts())
            ->add($this->projects())
            ->add($this->taggedPosts())
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
    private function posts(): array
    {
        return Post::query()
            ->with('images')
            ->select('id', 'title', 'image_lg', 'slug')
            ->where('is_published', true)
            ->get()
            ->map(function (Post $post) {
                $main_image = "$this->site_url/$post->image_lg";

                $url = Url::create(route('posts.show', $post->slug))
                    ->addImage($main_image, $post->title);

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
    private function projects(): array
    {
        return Project::query()
            ->select('name', 'language')
            ->get()
            ->map(function (Project $project) {
                $lang = strtolower($project->language);
                $image_url = url("/storage/languages/$lang.webp");

                return Url::create(route('projects.show', $project->name))
                    ->addImage($image_url, $project->language);
            })
            ->toArray();
    }

    /**
     * @return array<int, Url>
     */
    private function taggedPosts(): array
    {
        return Tag::query()
            ->whereHas('posts', fn(Builder $q) => $q->where('is_published', true))
            ->pluck('name')
            ->map(fn(string $tag) => Url::create(route('posts.index', ['tag' => $tag])))
            ->toArray();
    }

    private function aboutMe(): Url
    {
        $image_url = url('/storage/serhii-cho.webp');

        return Url::create(url('/about-me'))
            ->addImage($image_url, 'Serhii Cho photo');
    }
}
