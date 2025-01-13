<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\Subscription\DemandResponse;
use App\Models\Subscription;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

readonly class SubscriptionDemandService
{
    public const ALL_TAGS = 'all';
    public const NO_TAGS = 'none';

    public function __construct(private string $email, private Stringable $tags)
    {
    }

    public function handle(): DemandResponse
    {
        if ($this->tags->is(self::NO_TAGS)) {
            return new DemandResponse(false, 'Choose tags to subscribe');
        }

        $old_sub = $this->getOldSubscription();

        if ($old_sub && $this->isConfirmed($old_sub)) {
            $msg = 'Thank you! You are already subscribed. You will be notified when the new post is published';
            return new DemandResponse(true, $msg);
        }

        if ($old_sub && $this->notConfirmed($old_sub) && $this->createdToday($old_sub)) {
            return new DemandResponse(true, 'Please, check you email to confirm the subscription, or try tomorrow');
        }

        $subscription = $old_sub ?? $this->createSubscription();

        if (!$old_sub && $this->notAllTagsSelected()) {
            $tags = $this->tags->explode(',');
            $subscription->tags()->attach($tags);
        }

        $subscription->notifySubConfirmation();

        return new DemandResponse(true, 'Please, check you email to confirm your subscription');
    }

    public function createSubscription(): Subscription
    {
        /** @var Subscription */
        return Subscription::query()->create([
            'email' => $this->email,
            'slug' => Str::random(50),
        ]);
    }

    private function getOldSubscription(): Subscription|null
    {
        /** @var Subscription|null */
        return Subscription::query()->where('email', $this->email)->first();
    }

    private function notConfirmed(Subscription $old_sub): bool
    {
        return !$old_sub->confirmed_at;
    }

    public function isConfirmed(Subscription $old_sub): bool
    {
        return (bool) $old_sub->confirmed_at;
    }

    private function createdToday(Subscription $old_sub): bool
    {
        return $old_sub->created_at->isToday();
    }

    public function notAllTagsSelected(): bool
    {
        return !$this->tags->is('') && !$this->tags->is(self::ALL_TAGS);
    }
}
