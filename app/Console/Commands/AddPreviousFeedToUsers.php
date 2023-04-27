<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\BadgeName;
use App\Models\Badge;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Feed;
use App\Models\PostLike;
use App\Models\User;
use Illuminate\Console\Command;

class AddPreviousFeedToUsers extends Command
{
    protected $signature = 'users:add-feed';
    protected $description = 'Add previous feed to users like registration event, comments and likes';

    public function handle(): int
    {
        $processed = 0;

        $users = User::query()->whereNotNull('email_verified_at')->get();

        /** @var Badge $badge */
        $badge = Badge::query()->where('name', BadgeName::VERIFIED)->firstOrFail();

        foreach ($users as $user) {
            Feed::giveBadgeFeedItem($user, $badge);

            $comments = $user->comments()->with('post')->get();

            $comments->each(function (Comment $comment) use ($user) {
                Feed::giveCommentFeedItem($user, $comment);
            });

            $post_likes = $user->postLikes()->with('post')->get();

            $post_likes->each(function (PostLike $like) use ($user) {
                Feed::givePostLikeFeedItem($user, $like);
            });

            $comment_likes = $user->commentLikes()->with('comment.post', 'comment.user')->get();

            $comment_likes->each(function (CommentLike $like) use ($user) {
                Feed::giveCommentLikeFeedItem($user, $like);
            });

            $processed++;
        }

        $this->info("Processed {$processed} users");

        return Command::SUCCESS;
    }
}
