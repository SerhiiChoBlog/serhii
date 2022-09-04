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
        $today_hit = Hit::query()->whereDate('created_at', today())->first();

        $exclude_ips = explode(',', config('app.hits_exclude_ips'));

        if (in_array($request->ip(), $exclude_ips, true) || auth()->check()) {
            return $next($request);
        }

        if ($today_hit) {
            $today_hit->increment('amount');
        } else {
            Hit::query()->create();
        }

        return $next($request);
    }
}
