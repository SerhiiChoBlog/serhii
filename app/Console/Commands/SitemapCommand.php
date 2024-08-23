<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\PostContentImage;
use App\Models\Series;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapCommand extends Command
{
    protected $signature = 'make:sitemap';
    protected $description = 'Generate sitemap for the website';

    public function handle(): int
    {
        $path = public_path('sitemap.xml');

        $result = Sitemap::create()
            ->add($this->pages())
            ->add($this->posts())
            ->add($this->series())
            ->add($this->taggedPosts())
            ->writeToFile($path);

        $tags_count = count($result->getTags());

        $this->changeLastModValues($path);

        $this->info("Sitemap is generated with <fg=yellow>{$tags_count}</> tags.");

        return Command::SUCCESS;
    }

    private function changeLastModValues(string $path): void
    {
        $content = file_get_contents($path);

        if (!$content) {
            return;
        }

        $regex = '/<lastmod>((\d{4}-\d{2}-\d{2})(.*?))<\/lastmod>/';
        $replace_to = '<lastmod>$2</lastmod>';

        $content = preg_replace($regex, $replace_to, $content);

        file_put_contents($path, $content);
    }

    /**
     * @return array<int, Url>
     */
    private function posts(): array
    {
        return Post::query()
            ->with('images', 'series')
            ->select('id', 'title', 'image_lg', 'slug', 'updated_at')
            ->where('is_published', true)
            ->get()
            ->map(function (Post $post) {
                $title = $post->title;

                if ($post->series->isNotEmpty()) {
                    $title = "{$post->series->first()->title}: {$title}";
                }

                $url = Url::create(route('posts.show', $post->slug))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setLastModificationDate($post->updated_at)
                    ->setPriority(.8)
                    ->addImage(asset($post->image_lg), $title);

                /** @var PostContentImage $image */
                foreach ($post->images as $image) {
                    $url = $url->addImage(asset($image->uri), $title);
                }

                return $url;
            })
            ->toArray();
    }

    /**
     * @return array<int, Url>
     */
    private function series(): array
    {
        return Series::query()
            ->select('id', 'title', 'image_lg', 'slug', 'updated_at')
            ->whereHas('posts', fn (Builder $q) => $q->where('is_published', true))
            ->get()
            ->map(function (Series $series) {
                return Url::create(route('series.show', $series->slug))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setLastModificationDate($series->updated_at)
                    ->setPriority(.8)
                    ->addImage(asset($series->image_lg), $series->title);
            })
            ->toArray();
    }

    /**
     * @return array<int, Url>
     */
    private function taggedPosts(): array
    {
        return Tag::query()
            ->whereHas('posts', fn (Builder $q) => $q->where('is_published', true))
            ->get()
            ->map(function (Tag $tag) {
                return Url::create(route('posts.index', ['tag' => $tag->name]))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(.8)
                    ->addImage(asset("/storage/tags/{$tag->name}.webp"), $tag->title);
            })
            ->toArray();
    }

    /**
     * @return array<int, Url>
     */
    private function pages(): array
    {
        $pages = [
            [
                'priority' => 1.0,
                'change' => Url::CHANGE_FREQUENCY_WEEKLY,
                'url' => route('home'),
                'image' => null,
            ],
            [
                'priority' => .5,
                'change' => Url::CHANGE_FREQUENCY_MONTHLY,
                'url' => route('projects.index'),
                'image' => null,
            ],
            [
                'priority' => .6,
                'change' => Url::CHANGE_FREQUENCY_WEEKLY,
                'url' => route('posts.index'),
                'image' => null,
            ],
            [
                'priority' => .6,
                'change' => Url::CHANGE_FREQUENCY_WEEKLY,
                'url' => route('series.index'),
                'image' => null,
            ],
            [
                'priority' => .6,
                'change' => Url::CHANGE_FREQUENCY_MONTHLY,
                'url' => route('about-me'),
                'image' => [
                    'url' => asset('storage/serhii-cho.webp'),
                    'title' => 'About Serhii Cho',
                ],
            ],
            [
                'priority' => .3,
                'change' => Url::CHANGE_FREQUENCY_YEARLY,
                'url' => route('subscribe'),
                'image' => null,
            ],
        ];

        $result = [];

        foreach ($pages as $page) {
            $url = Url::create($page['url'])
                ->setPriority($page['priority'])
                ->setChangeFrequency($page['change']);

            if ($page['image'] !== null) {
                $url = $url->addImage($page['image']['url'], $page['image']['title']);
            }

            $result[] = $url;
        }

        return $result;
    }
}
