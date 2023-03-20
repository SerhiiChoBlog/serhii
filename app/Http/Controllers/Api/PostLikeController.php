<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostLike\StoreRequest;
use App\Models\User;

class PostLikeController extends Controller
{
    public function store(StoreRequest $request)
    {
        $user = User::getBySecret($request->secret);

        abort_if(!$user, 401);

        $user->likePost($request->post_id);
    }
}
