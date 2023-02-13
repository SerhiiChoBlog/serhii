<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Comment;
use App\Models\User;
use App\Notifications\NewComment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NewCommentAdminEmail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private readonly Comment $comment)
    {
    }

    public function handle(): void
    {
        $this->comment->loadMissing('post', 'user');

        /** @var User $admin */
        $admin = User::query()
            ->where('id', 1)
            ->first();

        $admin->notify(new NewComment($this->comment));
    }
}
