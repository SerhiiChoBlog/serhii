<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class SetMainTagForTags extends Command
{
    protected $signature = 'tags:set-main';
    protected $description = 'Sets main tags in tags table';

    public function handle(): int
    {
        /** @var Collection<int, Post> $posts */
        $posts = Post::with('tags')->get();

        $main_tags = [
            1 => 3, // js
            2 => 8, // laravel
            3 => 16, // philosophy
            4 => 10, // seo
            5 => 14, // web
            7 => 16, // philosophy
            9 => 8, // laravel
            10 => 19, // vue
            12 => 16, // philosophy
            11 => 21, // linux
            13 => 8, // laravel
            14 => 10, // seo
            15 => 22, // wordpress
            16 => 14, // web
            18 => 24, // clean code
            19 => 24, // clean code
            20 => 3, // js
            21 => 3, // js
            22 => 25, // svelte
            23 => 8, // laravel
        ];

        $posts->each(function (Post $post) use ($main_tags) {
            $result = [];

            foreach ($post->tags as $tag) {
                $result[$tag->id] = [
                    'is_main' => $tag->id === $main_tags[$post->id],
                ];
            }

            $post->tags()->detach();
            $post->tags()->attach($result);
        });

        return Command::SUCCESS;
    }
}
