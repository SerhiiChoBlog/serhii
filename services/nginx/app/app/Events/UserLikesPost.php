<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\PostLike;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLikesPost
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public User $user, public PostLike $post_like)
    {
    }
}
