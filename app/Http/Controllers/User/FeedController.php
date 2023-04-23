<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Dto\FeedItem;
use App\Http\Controllers\Controller;
use App\Models\User;

class FeedController extends Controller
{
    /**
     * @return array<int, FeedItem>
     */
    public function __invoke(User $user): array
    {
        return [

        ];
    }
}
