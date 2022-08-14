<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function subscribe(string $email): void
    {
        /** @var Subscription $subscription */
        $subscription = Subscription::query()->create(compact('email'));

        $subscription->notifySubConfirmation();
    }
}
