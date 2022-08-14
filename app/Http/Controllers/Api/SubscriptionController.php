<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function subscribe(string $email): string
    {
        $slug = Str::random(50);

        /** @var Subscription $old_sub */
        $old_sub = Subscription::query()->where('email', $email)->first();

        if ($old_sub && $old_sub->confirmed_at) {
            return 'Thank you! You are already subscribed. You will be notified when the new post is published';
        }

        if ($old_sub && !$old_sub->confirmed_at && $old_sub->created_at->isToday()) {
            return 'Please, check you email to confirm the subscription, or try tomorrow';
        }

        /** @var Subscription $subscription */
        $subscription = Subscription::query()->create(compact('email', 'slug'));

        $subscription->notifySubConfirmation();

        return 'Please, check you email to confirm your subscription';
    }
}
