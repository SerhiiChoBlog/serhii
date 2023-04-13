<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WpPagerUser\StoreRequest;
use App\Models\WpPagerUser;

class WpPagerUserController extends Controller
{
    public function store(StoreRequest $request): void
    {
        /** @var WpPagerUser|null $old */
        $old = WpPagerUser::query()->where('host', $request->host)->first();

        if ($old) {
            $old->update($request->only('is_active'));
            return;
        }

        WpPagerUser::query()->create($request->only('host', 'is_active'));
    }
}
