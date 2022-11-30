<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class FillImageXs extends Command
{
    protected $signature = 'posts:fill-image-xs';
    protected $description = 'Fill in image_xs column in posts table';

    public function handle(): int
    {
        /** @var Collection<int, Post> $posts */
        $posts = Post::query()->get();

        foreach ($posts as $post) {
            $image_xs = str_replace('/sm/', '/xs/', $post->image_sm);
            $post->update(compact('image_xs'));
        }

        return 0;
    }
}
