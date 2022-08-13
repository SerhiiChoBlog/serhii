<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SimpleMessage;
use Illuminate\Notifications\Notification;

class ConfirmSubscription extends Notification
{
    use Queueable;

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
            ->subject('Confirm your subscription to Serhii Cho email list')
            ->markdown('mail.confirm-subscription', [
                'confirmation_url'=> $this->getConfirmationUrl(),
                'decline_url'=> $this->getDeclineUrl(),
            ]);
    }

    private function getConfirmationUrl(): string
    {
        return url('/');
    }

    private function getDeclineUrl(): string
    {
        return url('/');
    }
}
