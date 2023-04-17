<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Services\Comment\StoreCommentService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    /**
     * @return Collection<int, Comment>
     */
    public function index(Post $post): Collection
    {
        $post->load([
            'comments' => function ($q) {
                $q->where('comment_id', null)
                    ->where('is_approved', true)
                    ->orderByDesc('created_at')
                    ->with('user:' . User::POST_COMMENT_FIELDS)
                    ->with([
                        'comments' => function ($q) {
                            $q->where('is_approved', true)
                                ->with('user:' . User::POST_COMMENT_FIELDS);
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
}
