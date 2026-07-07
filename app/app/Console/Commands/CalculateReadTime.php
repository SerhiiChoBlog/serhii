<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class CalculateReadTime extends Command
{
    protected $signature = 'posts:read-time';
    protected $description = 'Recalculate read time for each post';

    public function handle(): void
    {
        $posts = Post::query()->where('is_published', true)->get();

        $posts->each(static function (Post $post) {
            $post->read_time = Post::calculateEstimatedReadingTime($post->content ?? '');
            $post->save();
        });

        $this->info(sprintf('%d posts has updated the page views', $posts->count()));
    }
}
