<?php

declare(strict_types=1);

namespace App\Services\Comment;

use App\Models\Feed;
use App\Models\User;
use App\Enums\UserRole;
use App\Models\Comment;
use App\Utils\GlobalVisitor;
use Illuminate\Support\Carbon;
use App\Events\CommentApproved;
use App\Jobs\NewCommentAdminEmail;
use App\CommentModifiers\NewLineModifier;
use App\CommentModifiers\StripTagsModifier;
use App\CommentModifiers\ReplaceUrlsModifier;
use App\CommentModifiers\ReplacePostUrlsModifier;
use Illuminate\Validation\ValidationException;

class StoreCommentService
{
    private readonly bool $is_admin;
    private readonly string $comment;

    private const COMMENT_MODIFIERS = [
        ReplacePostUrlsModifier::class,
        StripTagsModifier::class,
        ReplaceUrlsModifier::class,
        NewLineModifier::class,
    ];

    public function __construct(
        private readonly User $user,
        string $comment,
        private readonly int $post_id,
        private ?int $comment_id,
    ) {
        $this->comment = $this->modifyComment($comment);
        $this->is_admin = $this->user->hasRole(UserRole::ADMIN);
    }

    /**
     * @return array{date: Carbon, message: string}
     *
     * @throws ValidationException
     */
    public function handle(): array
    {
        $this->validateUser();

        $timeout_minutes = (int) config('app.comments_timeout_minutes');
        $parent = $this->getParentComment();

        if ($parent && $parent->comment_id !== null) {
            $this->comment_id = $parent->comment_id;
        }

        $is_approved = $this->validateIfCommentIsApproved();

        $comment = $this->createComment($is_approved);
        $comment->setRelation('user', $this->user);

        NewCommentAdminEmail::dispatchIf(!$this->is_admin, $comment);

        if ($is_approved) {
            CommentApproved::dispatch($this->user);
            Feed::giveCommentFeedItem($comment);
        }

        return [
            'date' => $this->is_admin ? now() : now()->addMinutes($timeout_minutes),
            'message' => $this->getResponseMessage($is_approved),
        ];
    }

    private function isSpam(int $timeout_minutes): bool
    {
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
        if ($this->is_admin) {
            return true;
        }

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

        if (!$ip || $ip === '127.0.0.1') {
            return null;
        }

        return GlobalVisitor::getInstance()->get()?->id;
    }

    private function createComment(bool $is_approved): Comment
    {
        /** @var Comment */
        return $this->user->comments()->create([
            'post_id' => $this->post_id,
            'visitor_id' => $this->getVisitorId(),
            'comment_id' => $this->comment_id,
            'comment' => $this->comment,
            'is_approved' => $is_approved,
            'created_at' => now(),
        ]);
    }

    private function modifyComment(string $comment): string
    {
        foreach (self::COMMENT_MODIFIERS as $modifier) {
            $instance = new $modifier($comment);
            $comment = $instance->modify();
        }

        return $comment;
    }

    private function getResponseMessage(bool $is_approved): string
    {
        return $is_approved
            ? 'Thank you! Your comment has been posted'
            : 'Thank you! Your comment has been posted and will be reviewed shortly';
    }

    private function validateUser(): void
    {
        if ($this->is_admin) {
            return;
        }

        $timeout_minutes = (int) config('app.comments_timeout_minutes');

        if ($this->isSpam($timeout_minutes)) {
            $msg = "You can only post one comment every {$timeout_minutes} minutes.";
            throw ValidationException::withMessages(['comment' => $msg]);
        }

        if ($this->user->email_verified_at === null) {
            $msg = 'Only verified users can post comments. Please check your email for a verification link.';
            throw ValidationException::withMessages(['secret' => $msg]);
        }

        if ($this->user->ban()->exists()) {
            $msg = 'You have been banned from posting comments.';
            throw ValidationException::withMessages(['comment' => $msg]);
        }
    }
}
