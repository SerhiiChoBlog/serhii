<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Hit;
use Closure;
use Illuminate\Http\Request;

class HitMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (!$request->isMethod('get')) {
            return $next($request);
        }

        /** @var Hit|null $today_hit */
        $today_hit = Hit::query()->whereDate('updated_at', today())->first();

        $today_hit
            ? $today_hit->query()->increment('amount')
            : Hit::query()->create();

        return $next($request);
    }
}
