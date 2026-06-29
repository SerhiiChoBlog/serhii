<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class UpdateSeriesPostsSlugs extends Command
{
    protected $signature = 'posts:update-slugs';
    protected $description = 'Update slugs of posts in series';

    public function handle(): int
    {
        $slugs = [
            'boost-your-svelte-apps-performance' => 'lazy-loading-boost-your-svelte-apps-performance',
            'vue-component-wrapper-for-lazy-loading' => 'lazy-loading-vue-component-wrapper-for-lazy-loading',
            'intersection-observer-is-a-hidden-feature-of-javascript' => 'lazy-loading-intersection-observer-is-a-hidden-feature-of-javascript',
            'the-basics-of-programming' => 'understanding-computer-fundamentals-the-basics-of-programming',
            'computer-software' => 'understanding-computer-fundamentals-computer-software',
            'the-basics-of-computers' => 'understanding-computer-fundamentals-the-basics-of-computers',
        ];

        foreach ($slugs as $old_slug => $new_slug) {
            /** @var Post|null $post */
            $post = Post::query()->where('slug', $old_slug)->first();

            if (!$post) {
                continue;
            }

            $post->slug = $new_slug;
            $post->save();
        }

        return Command::SUCCESS;
    }
}
