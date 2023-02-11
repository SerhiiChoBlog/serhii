<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentController extends Controller
{
    /**
     * @return array{
     *   comments: LengthAwarePaginator<Comment>,
     *   total: int,
     * }
     */
    public function index(): array
    {
        $comments = Comment::query()
            ->with('user', 'post', 'parent')
            ->orderByDesc('created_at')
            ->paginate(20);

        return [
            'comments' => $comments,
            'total' => Comment::query()->count(),
        ];
    }

    public function show(Comment $comment): Comment
    {
        $comment->load('user', 'post', 'parent');
        return $comment;
    }

    public function approve(string $id): bool
    {
        Comment::query()->find($id)?->update(['is_approved' => true]);
        return true;
    }

    public function disapprove(string $id): bool
    {
        Comment::query()->find($id)?->update(['is_approved' => false]);
        return false;
    }
}
