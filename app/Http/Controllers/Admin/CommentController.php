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
}
