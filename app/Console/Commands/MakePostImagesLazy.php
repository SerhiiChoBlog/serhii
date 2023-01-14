<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\LazyLoadingParser;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class MakePostImagesLazy extends Command
{
    protected $signature = 'posts:lazy';
    protected $description = 'Make post images with lazy loading';

    public function handle(): void
    {
        /** @var Collection<int, Post> $posts */
        $posts = Post::query()->select('id', 'content')->get();

        $posts->each(function (Post $post) {
            if ($post->content) {
                $content = LazyLoadingParser::makeImagesLazy($post->content);
                $post->update(compact('content'));
            }
        });

        $this->info("Done!");
    }
}
