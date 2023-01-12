<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Referrer;
use Closure;
use Illuminate\Http\Request;

class ReferrerMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        $referer_site = request()->headers->get('referer');

        if (!$referer_site || !$request->isMethod('get') || str_starts_with($referer_site, 'https://serhii.io')) {
            return $next($request);
        }

        $old = Referrer::query()->where('site', $referer_site)->first();

        if ($old) {
            $old->increment('hits');
        } else {
            Referrer::query()->create([
                'site' => $referer_site,
                'hits' => 1,
            ]);
        }

        return $next($request);
    }
}
