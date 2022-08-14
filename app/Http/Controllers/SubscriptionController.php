<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SubscriptionController extends Controller
{
    public function confirm(string $slug): View | RedirectResponse
    {
        $sub = Subscription::query()->where('slug', $slug)->first();

        if (!$sub) {
            return to_route('subscriptions.error');
        }

        $sub->update(['confirmed_at' => now()]);

        return view('subscriptions.confirm');
    }

    public function decline(string $slug): View | RedirectResponse
    {
        $sub = Subscription::query()->where('slug', $slug)->first();

        if (!$sub) {
            return view('subscriptions.decline');
        }

        $sub->delete();

        return view('subscriptions.decline');
    }
}
