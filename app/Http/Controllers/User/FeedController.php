<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Feed;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class FeedController extends Controller
{
    /**
     * @return LengthAwarePaginator<Feed>
     */
    public function __invoke(User $user): LengthAwarePaginator
    {
        return $user->feed()->paginate(10);
    }
}
