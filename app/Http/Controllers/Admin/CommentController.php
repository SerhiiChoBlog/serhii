<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
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
            ->with('user', 'post', 'parent', 'visitor')
            ->withCount('likes')
            ->orderBy('is_approved')
            ->orderByDesc('created_at')
            ->paginate(20);

        return [
            'comments' => $comments,
            'total' => Comment::query()->count(),
        ];
    }

    public function approve(Comment $comment): void
    {
        $comment->update(['is_approved' => true]);
    }

    public function disapprove(Comment $comment): void
    {
        $comment->update(['is_approved' => false]);
    }

    public function destroyAll(User $user): void
    {
        $user->comments()->delete();
    }

    public function destroy(Comment $comment): void
    {
        $comment->delete();
    }
}
