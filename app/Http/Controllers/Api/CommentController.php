<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
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

    public function store(): Comment
    {
        $service = new StoreCommentService('Serhii Cho');
        return $service->handle();
    }
}
