<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Feed;
use App\Models\User;
use Illuminate\Support\Collection;

class FeedController extends Controller
{
    /**
     * @return Collection<int, Feed>
     */
    public function __invoke(User $user): Collection
    {
        return $user->feed()
            ->with('comment:id,comment')
            ->with('comment.user:id,name,avatar,slug')
            ->with('user:id,name')
            ->with('badge')
            ->with('post:id,title,intro,slug,image_xs')
            ->limit(10)
            ->get();
    }
}
