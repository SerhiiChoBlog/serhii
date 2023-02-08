<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Services\StoreCommentService;
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
        $user_columns = 'id,name,slug,avatar,sign_in_method';

        $post->load([
            'comments' => function ($q) use ($user_columns) {
                $q->where('comment_id', null)
                    ->where('is_approved', true)
                    ->orderByDesc('created_at')
                    ->with("user:{$user_columns}")
                    ->with([
                        'comments' => function ($q) use ($user_columns) {
                            $q->where('is_approved', true)
                                ->with("user:{$user_columns}");
                        },
                    ]);
            },
        ]);

        return $post->comments;
    }

    /**
     * @throws ValidationException
     */
    public function store(StoreRequest $r): Carbon
    {
        /** @var User $user */
        $user = User::query()->where('secret', $r->secret)->firstOrFail();

        $service = new StoreCommentService($user, $r->comment, $r->post_id, $r->comment_id);

        return $service->handle();
    }
}
