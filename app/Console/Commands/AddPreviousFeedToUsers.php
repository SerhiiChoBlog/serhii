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
            Feed::giveBadgeFeedItem($user, BadgeName::VERIFIED);

            $comments = $user->comments()->with('post', 'user')->get();

            $comments->each(function (Comment $comment) {
                Feed::giveCommentFeedItem($comment);
            });

            $post_likes = $user->postLikes()->with('post')->get();

            $post_likes->each(function (PostLike $like) use ($user) {
                Feed::givePostLikeFeedItem($user, $like);
            });

            $comment_likes = $user->commentLikes()->with('comment.post', 'comment.user')->get();

            $comment_likes->each(function (CommentLike $like) use ($user) {
                Feed::giveCommentLikeFeedItem($user, $like);
            });

            if ($user->comments->count() >= Badge::POST_COMMENTS) {
                Feed::giveBadgeFeedItem($user, BadgeName::COMMENTATOR);
            }

            if ($user->postLikes->count() >= Badge::POST_LIKES) {
                Feed::giveBadgeFeedItem($user, BadgeName::LOVELY);
            }

            $processed++;
        }

        $this->info("Processed {$processed} users");

        return Command::SUCCESS;
    }
}
