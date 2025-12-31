<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SimpleMessage;
use Illuminate\Notifications\Notification;

class NewComment extends Notification
{
    use Queueable;

    public function __construct(private readonly Comment $comment)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return list<string>
     */
    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): SimpleMessage
    {
        $status = $this->comment->is_approved ? 'approved' : 'pending';

        return (new MailMessage())
            ->subject("New {$status} comment!")
            ->markdown('mail.new-comment', [
                'comment' => $this->comment,
            ]);
    }
}
