<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscription\SubscribeRequest;
use App\Models\Subscription;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function subscribe(SubscribeRequest $request): string
    {
        $slug = Str::random(50);

        if ($request->tags->is(SubscribeRequest::NO_TAGS)) {
            return 'Choose topics to subscribe';
        }

        /** @var Subscription|null $old_sub */
        $old_sub = Subscription::query()->where('email', $request->email)->first();

        if ($old_sub && $old_sub->confirmed_at) {
            return 'Thank you! You are already subscribed. You will be notified when the new post is published';
        }

        if ($old_sub && !$old_sub->confirmed_at && $old_sub->created_at->isToday()) {
            return 'Please, check you email to confirm the subscription, or try tomorrow';
        }

        if ($old_sub) {
            $subscription = $old_sub;
        } else {
            /** @var Subscription $subscription */
            $subscription = Subscription::query()->create([
                'email' => $request->email,
                'slug' => $slug,
            ]);
        }

        if (!$old_sub && !$request->tags->is(SubscribeRequest::ALL_TAGS)) {
            $tags = $request->tags->explode(',');
            $subscription->tags()->attach($tags);
        }

        $subscription->notifySubConfirmation();

        return 'Please, check you email to confirm your subscription';
    }
}
