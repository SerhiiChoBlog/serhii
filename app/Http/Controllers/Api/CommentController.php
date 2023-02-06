<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Services\StoreCommentService;
use Illuminate\Support\Collection;

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
                    ->with('user')
                    ->with([
                        'comments' => function ($q) {
                            $q->where('is_approved', true)
                                ->with('user');
                        },
                    ]);
            },
        ]);

        return $post->comments;
    }

    public function store(StoreRequest $r): void
    {
        /** @var User $user */
        $user = User::query()->findOrFail($r->user_id);

        $service = new StoreCommentService($user, $r->comment, $r->post_id, $r->comment_id);
        $service->handle();
    }
}
