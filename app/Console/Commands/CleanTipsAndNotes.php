<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class CleanTipsAndNotes extends Command
{
    protected $signature = 'posts:clean-tips';
    protected $description = 'Removes span elements from tip and notes HTML tags in post content';

    public function handle(): int
    {
        $posts = $this->getPosts();

        foreach ($posts as $post) {
            $post->content = $this->changeContent($post->content ?? '');
            $post->save();
        }

        $this->info("{$posts->count()} posts updated");

        return Command::SUCCESS;
    }

    /**
     * @return Collection<int, Post>
     */
    private function getPosts(): Collection
    {
        return Post::query()
            ->select('id', 'content')
            ->whereNotNull('content')
            ->get();
    }

    private function changeContent(string $content): string
    {
        $elements = [
            '<span class="hidden" aria-label="Note">Note. </span>',
            '<span class="hidden" aria-label="Tip">Tip. </span>',
            '<span class="hidden" aria-label="Warning">Warning. </span>',
        ];

        return str_replace($elements, '', $content);
    }
}
