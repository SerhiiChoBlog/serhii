<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SimpleMessage;
use Illuminate\Notifications\Notification;

class ConfirmSubscription extends Notification
{
    use Queueable;

    public function __construct(public Subscription $subscription)
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
            ->subject('Confirm your subscription to Serhii Cho email list')
            ->markdown('mail.confirm-subscription', [
                'confirmation_url' => $this->getConfirmationUrl(),
                'decline_url' => $this->getDeclineUrl(),
                'subscription' => $this->subscription,
            ]);
    }

    private function getConfirmationUrl(): string
    {
        return route('subscriptions.confirm', $this->subscription->slug);
    }

    private function getDeclineUrl(): string
    {
        return route('subscriptions.decline', $this->subscription->slug);
    }
}
