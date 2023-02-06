<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Models\Visitor;

readonly class StoreCommentService
{
    public function __construct(
        private User $user,
        private string $comment,
        private int $post_id,
        private ?int $comment_id,
    ) {
    }

    public function handle(): void
    {
        $this->user->comments()->create([
            'post_id' => $this->post_id,
            'visitor_id' => $this->getVisitorId(),
            'comment_id' => $this->comment_id,
            'comment' => $this->comment,
            'is_approved' => $this->validateIfCommentIsApproved(),
        ]);
    }

    private function getVisitorId(): int
    {
        $ip = request()->ip();

        if (!$ip) {
            return 1;
        }

        return Visitor::getOrCreateVisitor($ip)->id ?? 1;
    }

    private function validateIfCommentIsApproved(): bool
    {
        return true;
    }
}
