<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Post;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SimpleMessage;
use Illuminate\Notifications\Notification;

class PostPublished extends Notification
{
    use Queueable;

    public function __construct(private Post $post, private Subscription $subscription)
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
        return (new MailMessage())
            ->subject(sprintf('New post: "%s"', $this->post->title))
            ->markdown('mail.post-published', [
                'post' => $this->post,
                'url' => route('posts.show', $this->post),
                'nice_url' => route('posts.show', $this->post),
                'unsubscribe' => $this->unsubscribeUrl(),
            ]);
    }

    private function unsubscribeUrl(): string
    {
        return route('subscriptions.unsubscribe', $this->subscription->slug);
    }
}
