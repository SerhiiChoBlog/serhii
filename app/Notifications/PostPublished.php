<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SimpleMessage;
use Illuminate\Notifications\Notification;

class PostPublished extends Notification
{
    use Queueable;

    public function __construct(private Post $post)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): SimpleMessage
    {
        return (new MailMessage)
            ->subject(sprintf('New post: "%s"', $this->post->title))
            ->markdown('mail.post-published', [
                'post'=> $this->post,
                'unsubscribe' => $this->unsubscribeUrl(),
            ]);
    }

    private function unsubscribeUrl(): string
    {
        return url('/');
    }
}
