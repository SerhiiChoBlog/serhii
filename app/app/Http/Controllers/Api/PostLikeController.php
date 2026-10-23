<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Events\UserLikesPost;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostLike\IsLikedRequest;
use App\Http\Requests\Api\PostLike\StoreRequest;
use App\Models\PostLike;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;

class PostLikeController extends Controller
{
    /**
     * @return array{likes: int, liked: bool}
     */
    public function store(StoreRequest $request): array
    {
        $user = user();

        abort_if(!$user, ResponseStatus::HTTP_UNAUTHORIZED);

        $already_liked = $user->hasLikedPost($request->post_id);

        if ($already_liked) {
            return ['likes' => $this->getPostLikes($request->post_id), 'liked' => true];
        }

        $user->loadCount('postLikes');
        $post_like = $user->likePost($request->post_id);

        /** @var PostLike $post_like */
        $post_like = PostLike::query()
            ->where('id', $post_like->id)
            ->with('post:id,slug,title,image_xs')
            ->firstOrFail();

        UserLikesPost::dispatch($user, $post_like);

        return ['likes' => $this->getPostLikes($request->post_id), 'liked' => true];
    }

    /**
     * @return array{liked: bool, likes: int}
     */
    public function isLiked(IsLikedRequest $request): array
    {
        $user = user();

        return [
            'liked' => $user && $user->hasLikedPost((int) $request->post_id),
            'likes' => $this->getPostLikes((int) $request->post_id),
        ];
    }

    private function getPostLikes(int $post_id): int
    {
        return PostLike::query()->where('post_id', $post_id)->count();
    }
}
