<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class SearchWordThroughPosts extends Command
{
    protected $signature = 'posts:search-word';
    protected $description = "Search word through all the posts' content";

    public function handle(): int
    {
        /** @var Collection<int, Post> $posts */
        $posts = Post::query()->get();

        /** @var string $word */
        $word = $this->ask('Enter the word you want to search for in the post content');

        $posts->each(function (Post $post) use ($word) {
            if ($post->content && str_contains($post->content, $word)) {
                $this->info("The word '{$word}' was found in the post: {$post->slug}");
            }
        });

        return Command::SUCCESS;
    }
}
