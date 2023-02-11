<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserRole;
use App\Events\CommentApproved;
use App\Models\Comment;
use App\Models\User;
use App\Models\Visitor;
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
     * @return array{date: Carbon, message: string}
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

        if ($this->user->email_verified_at === null) {
            $msg = 'Only verified users can post comments. Please check your email for a verification link.';
            throw ValidationException::withMessages(['secret' => $msg]);
        }

        $parent = $this->getParentComment();

        if ($parent && $parent->comment_id !== null) {
            $this->comment_id = $parent->comment_id;
        }

        $is_approved = $this->validateIfCommentIsApproved();

        $this->user->comments()->create([
            'post_id' => $this->post_id,
            'visitor_id' => $this->getVisitorId(),
            'comment_id' => $this->comment_id,
            'comment' => $this->comment,
            'is_approved' => $is_approved,
            'created_at' => now(),
        ]);

        $date = $this->is_admin ? now() : now()->addMinutes($timeout_minutes);

        $message = $is_approved
            ? 'Thank you! Your comment has been posted'
            : 'Thank you! Your comment has been posted and will be reviewed shortly';

        CommentApproved::dispatchIf($is_approved, $this->user);

        return compact('date', 'message');
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
        $spam_words = config('spam-words');
        $comment = mb_strtolower($this->comment);

        // Check if comment contains spam words
        foreach ($spam_words as $word) {
            if (preg_match("/\b{$word}\b/", $comment)) {
                return false;
            }
        }

        return true;
    }

    private function getVisitorId(): ?int
    {
        $ip = request()->ip();

        if (!$ip) {
            return null;
        }

        return Visitor::getOrCreateVisitor($ip)?->id;
    }
}
