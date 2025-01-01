<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SubscriptionController extends Controller
{
    public function confirm(string $slug): View|RedirectResponse
    {
        $subscription = Subscription::with('tags')->where('slug', $slug)->first();

        if (!$subscription) {
            return to_route('subscriptions.error');
        }

        /** @var User|null $connected_user */
        $connected_user = User::query()
            ->where('email', $subscription->email)
            ->first();

        $subscription->update([
            'user_id' => $connected_user?->id,
            'confirmed_at' => now(),
        ]);

        return view('subscriptions.confirm', compact('subscription'));
    }

    public function decline(string $slug): View
    {
        /** @var Subscription|null $sub */
        $sub = Subscription::query()->where('slug', $slug)->first();

        if (!$sub) {
            return view('subscriptions.decline');
        }

        $sub->tags()->detach();
        $sub->delete();

        return view('subscriptions.decline');
    }

    public function unsubscribe(string $slug): View
    {
        /** @var Subscription|null $sub */
        $sub = Subscription::query()->where('slug', $slug)->first();

        if (!$sub) {
            return view('subscriptions.unsubscribe');
        }

        $sub->tags()->detach();
        $sub->delete();

        return view('subscriptions.unsubscribe');
    }
}
