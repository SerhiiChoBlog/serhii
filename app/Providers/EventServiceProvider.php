<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\CommentApproved;
use App\Events\PostChanged;
use App\Events\UserLikesPost;
use App\Events\UserUnlikesPost;
use App\Listeners\Badges\GiveUserCommentatorBadge;
use App\Listeners\Badges\GiveUserLovelyBadge;
use App\Listeners\Badges\GiveUserVerifiedBadge;
use App\Listeners\Badges\RemoveLovelyBadgeFromUser;
use App\Listeners\ClearPostsCache;
use App\Listeners\ConnectSubscriptionToUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Verified::class => [
            ConnectSubscriptionToUser::class,
            GiveUserVerifiedBadge::class,
        ],
        CommentApproved::class => [
            GiveUserCommentatorBadge::class,
        ],
        PostChanged::class => [
            ClearPostsCache::class,
        ],
        UserLikesPost::class => [
            GiveUserLovelyBadge::class,
        ],
        UserUnlikesPost::class => [
            RemoveLovelyBadgeFromUser::class,
        ],
    ];
}
