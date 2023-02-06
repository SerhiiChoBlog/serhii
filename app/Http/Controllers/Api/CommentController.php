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
        return $post->comments;
    }

    public function store(StoreRequest $request): Comment
    {
        $user = User::getBySlug($request->user_slug);

        $service = new StoreCommentService($user);

        return $service->handle();
    }
}
