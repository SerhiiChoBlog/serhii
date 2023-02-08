<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserRole;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class StoreCommentService
{
    private bool $is_admin;

    public function __construct(
        private readonly User $user,
        private readonly string $comment,
        private readonly int $post_id,
        private ?int $comment_id,
    ) {
        $this->is_admin = $this->user->hasRole(UserRole::ADMIN);
    }

    /**
     * @return array{date: Carbon}
     *
     * @throws ValidationException
     */
    public function handle(): array
    {
        $timeout_minutes = (int) config('app.comments_timeout_minutes');

        if ($this->isSpam($timeout_minutes)) {
            $msg = "You can only post one comment every {$timeout_minutes} minutes.";
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

        $date = $this->is_admin ? now() : now()->addMinutes($timeout_minutes);

        return compact('date');
    }

    private function isSpam(int $timeout_minutes): bool
    {
        if ($this->is_admin) {
            return false;
        }

        return $this->user
            ->comments()
            ->where('created_at', '>=', now()->subMinutes($timeout_minutes))
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
