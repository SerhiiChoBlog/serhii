<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostLike\StoreRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;

class PostLikeController extends Controller
{
    /**
     * @return array{liked: bool}
     */
    public function store(StoreRequest $request): array
    {
        $user = User::getBySecret($request->secret);

        abort_if(!$user, ResponseStatus::HTTP_UNAUTHORIZED);

        if ($user->hasLikedPost($request->post_id)) {
            $user->unlikePost($request->post_id);
            return ['liked' => false];
        }

        $user->likePost($request->post_id);

        return ['liked' => true];
    }
}
