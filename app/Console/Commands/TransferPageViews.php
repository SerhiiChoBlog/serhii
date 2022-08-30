<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\PageView;
use App\Models\Post;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class TransferPageViews extends Command
{
    protected $signature = 'views:transfer';
    protected $description = 'Transfers page views to post views';

    /**
     * @throws Exception
     */
    public function handle(): int
    {
        $skipped = [];

        /** @var Collection<int, PageView> $page_views */
        $page_views = PageView::query()->get();

        /** @var Collection<int, Post> $posts */
        $posts = Post::query()->get();

        foreach ($page_views as $page_view) {
            /** @var Post|null $post */
            $post = $posts->filter(fn(Post $post) => trim($post->slug) === trim($page_view->slug))->first();

            if (!$post) {
                $skipped[$page_view->id] = $page_view->slug;
                continue;
            }

            $post->postViews()->create([
                'visitor_id' => $page_view->visitor_id,
                'created_at' => $page_view->created_at,
            ]);
        }

        if (!empty($skipped)) {
            $this->error(sprintf('Skipped %d page views: %s', count($skipped), implode(', ', $skipped)));
            return 1;
        }

        $this->info('All the page views are transferred without errors');

        return 0;
    }
}
