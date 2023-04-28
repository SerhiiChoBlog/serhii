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

        foreach ($users as $user) {
            /** @phpstan-ignore-next-line */
            Feed::giveBadgeFeedItem($user, BadgeName::VERIFIED, $user->email_verified_at);

            $this->giveCommentsFeed($user);
            $this->givePostLikes($user);
            $this->giveCommentLikes($user);

            $this->giveCommentatorBadge($user);
            $this->giveLovelyBadge($user);

            $processed++;
        }

        $this->info("Processed {$processed} users");

        return Command::SUCCESS;
    }

    public function giveCommentLikes(mixed $user): void
    {
        $comment_likes = $user->commentLikes()->with('comment.post', 'comment.user')->get();

        $comment_likes->each(function (CommentLike $like) use ($user) {
            Feed::giveCommentLikeFeedItem($user, $like);
        });
    }

    public function givePostLikes(mixed $user): void
    {
        $post_likes = $user->postLikes()->with('post')->get();

        $post_likes->each(function (PostLike $like) use ($user) {
            Feed::givePostLikeFeedItem($user, $like);
        });
    }

    public function giveCommentsFeed(mixed $user): void
    {
        $comments = $user->comments()->with('post', 'user')->get();

        $comments->each(function (Comment $comment) {
            Feed::giveCommentFeedItem($comment);
        });
    }

    public function giveCommentatorBadge(mixed $user): void
    {
        if ($user->comments->count() < Badge::POST_COMMENTS) {
            return;
        }

        Feed::giveBadgeFeedItem($user, BadgeName::COMMENTATOR);
    }

    public function giveLovelyBadge(mixed $user): void
    {
        if ($user->postLikes->count() < Badge::POST_LIKES) {
            return;
        }

        Feed::giveBadgeFeedItem($user, BadgeName::LOVELY);
    }
}
