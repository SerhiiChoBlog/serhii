<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Events\UserLikesPost;
use App\Events\UserUnlikesPost;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostLike\IsLikedRequest;
use App\Http\Requests\Api\PostLike\StoreRequest;
use App\Models\Feed;
use App\Models\PostLike;
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

            UserUnlikesPost::dispatch($user);

            return [
                'liked' => false,
                'likes' => $this->getPostLikes($request->post_id),
            ];
        }

        $post_like = $user->likePost($request->post_id);

        $post_like = PostLike::query()
            ->where('id', $post_like->id)
            ->with('post:id,slug,title,image_xs')
            ->firstOrFail();

        Feed::givePostLikeFeedItem($user, $post_like);

        UserLikesPost::dispatch($user);

        return [
            'liked' => true,
            'likes' => $this->getPostLikes($request->post_id),
        ];
    }

    /**
     * @return array{liked: bool, likes: int}
     */
    public function isLiked(IsLikedRequest $request): array
    {
        $user = User::getBySecret($request->secret);

        return [
            'liked' => $user && $user->hasLikedPost((int)$request->post_id),
            'likes' => $this->getPostLikes((int) $request->post_id),
        ];
    }

    private function getPostLikes(int $post_id): int
    {
        return PostLike::query()->where('post_id', $post_id)->count();
    }
}
