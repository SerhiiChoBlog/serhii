<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class StoreCommentService
{
    public function __construct(
        private readonly User $user,
        private readonly string $comment,
        private readonly int $post_id,
        private ?int $comment_id,
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function handle(): void
    {
        if ($this->isSpam()) {
            $msg = 'You can only post one comment every 5 minutes.';
            throw ValidationException::withMessages(['comment' => $msg]);
        }

        $parent = $this->getParentComment();

        if ($parent && $parent->comment_id !== null) {
            $this->comment_id = $parent->comment_id;
        }

        $this->user->comments()->create([
            'post_id' => $this->post_id,
            'comment_id' => $this->comment_id,
            'comment' => $this->comment,
            'is_approved' => $this->validateIfCommentIsApproved(),
            'created_at' => now(),
        ]);
    }

    private function isSpam(): bool
    {
        return $this->user
            ->comments()
            ->where('created_at', '>=', now()->subMinutes(5))
            ->exists();
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
