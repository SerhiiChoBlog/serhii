<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Dto\Subscription\DemandResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subscription\SubscribeRequest;
use App\Services\SubscriptionDemandService;

class SubscriptionDemandController extends Controller
{
    public function subscribe(SubscribeRequest $request): DemandResponse
    {
        $service = new SubscriptionDemandService($request->email, $request->tags);
        return $service->handle();
    }
}
