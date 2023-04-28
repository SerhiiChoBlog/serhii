<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\FeedType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\IndexRequest;
use App\Http\Requests\Comment\LikeRequest;
use App\Http\Requests\Comment\StoreRequest;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Feed;
use App\Models\Post;
use App\Models\User;
use App\Services\Comment\StoreCommentService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    /**
     * @return Collection<int, Comment>
     */
    public function index(IndexRequest $request): Collection
    {
        /** @var Post $post */
        $post = Post::query()->findOrFail($request->post_id);
        $user = User::getBySecret($request->secret);

        $with = ['user:' . User::POST_COMMENT_FIELDS];

        if ($user) {
            $with['likes'] = fn (HasMany $q) => $q->where('user_id', $user->id);
        }

        $post->load([
            'comments' => function (HasMany $q) use ($with) {
                $q->where('comment_id', null)
                    ->where('is_approved', true)
                    ->orderByDesc('created_at')
                    ->withCount('likes')
                    ->with([
                        ...$with,
                        'comments' => function (HasMany $q) use ($with) {
                            $q->where('is_approved', true)
                                ->with($with)
                                ->withCount('likes');
                        },
                    ]);
            },
        ]);

        return $post->comments;
    }

    /**
     * @return array{date: Carbon}
     *
     * @throws ValidationException
     */
    public function store(StoreRequest $r): array
    {
        $user = User::getBySecret($r->secret);

        abort_if(!$user, 403, 'Invalid secret');

        $service = new StoreCommentService($user, $r->comment, $r->post_id, $r->comment_id);

        return $service->handle();
    }

    public function like(LikeRequest $r): void
    {
        $user = User::getBySecret($r->secret);

        abort_if(!$user, 403, 'Invalid secret');

        /** @var Comment $comment */
        $comment = Comment::query()->findOrFail($r->comment_id);

        $comment_exists = $comment->likes()->where('user_id', $user->id)->exists();

        if ($comment_exists) {
            $comment->likes()->where('user_id', $user->id)->delete();
            $comment->deleteFeedItem(FeedType::COMMENT_LIKE, $user->id);
            return;
        }

        /** @var CommentLike $like */
        $like = $comment->likes()->create(['user_id' => $user->id])->refresh();

        Feed::giveCommentLikeFeedItem($user, $like);
    }
}
