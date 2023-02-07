<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Comment;
use App\Models\User;

class StoreCommentService
{
    public function __construct(
        private readonly User $user,
        private readonly string $comment,
        private readonly int $post_id,
        private ?int $comment_id,
    ) {
    }

    public function handle(): void
    {
        $parent = $this->getParentComment();

        if ($parent && $parent->comment_id !== null) {
            $this->comment_id = $parent->comment_id;
        }

        $this->user->comments()->create([
            'post_id' => $this->post_id,
            'comment_id' => $this->comment_id,
            'comment' => $this->comment,
            'is_approved' => $this->validateIfCommentIsApproved(),
        ]);
    }

    private function getParentComment(): ?Comment
    {
        if (!$this->comment_id) {
            return null;
        }

        /** @var Comment|null */
        return Comment::query()
            ->where('id', $this->comment_id)
            ->first();
    }

    private function validateIfCommentIsApproved(): bool
    {
        return true;
    }
}
