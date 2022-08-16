<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\PostPublication;
use App\Models\Subscription;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Throwable;

class SubscriptionsNotify extends Command
{
    protected $signature = 'subscriptions:notify';
    protected $description = 'Sends email message to each subscribed email address';

    /**
     * @throws Exception
     */
    public function handle(): int
    {
        $subs = $this->getSubs();

        if ($subs->isEmpty()) {
            $this->error('No subscriptions');
            return 1;
        }

        $last_post = $this->getLastPost();
        $people_notified = 0;
        $errors = [];

        if ($this->hasPublicationWithThisPost($last_post->id)) {
            $this->error("<fg=red>Subscribers were already notified with post:\n</><fg=blue>\"$last_post->title\"</>");
            return 1;
        }

        foreach ($subs as $sub) {
            ++$people_notified;

            try {
                $sub->notifyPostPublished($last_post);
            } catch (Throwable $e) {
                $errors[] = $e->getMessage();
                continue;
            }
        }

        $last_post->postPublication()->create(compact('people_notified'));

        if (!empty($errors)) {
            logger()->error(implode("\n", $errors));
            $this->warn(sprintf("There were %d errors! Check your logs", count($errors)));
        }

        $msg = "$people_notified subscribers were successfully notified with post:\n<fg=blue>\"$last_post->title\"</>";

        $this->info($msg);

        return 0;
    }

    /**
     * @return Collection<int, Subscription>
     */
    private function getSubs(): Collection
    {
        return Subscription::query()->whereNotNull('confirmed_at')->get();
    }

    /**
     * @throws Exception
     */
    private function getLastPost(): Post
    {
        $post = Post::query()->where('is_published', true)->latest()->first();

        if (!$post) {
            throw new Exception('There are no posts in database');
        }

        return $post;
    }

    private function hasPublicationWithThisPost(int $post_id): bool
    {
        return PostPublication::query()
            ->where('post_id', $post_id)
            ->exists();
    }
}
