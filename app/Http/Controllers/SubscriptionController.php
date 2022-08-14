<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class SubscriptionController extends Controller
{
    public function confirm(): View
    {
        return view('subscriptions.confirm');
    }

    public function decline(): View
    {
        return view('subscriptions.decline');
    }
}
