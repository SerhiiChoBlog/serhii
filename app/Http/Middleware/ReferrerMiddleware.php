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
        $self_referrer = str_contains($referer_site ?? '', request()->getHttpHost());

        if (!$referer_site || $self_referrer || !$request->isMethod('get')) {
            return $next($request);
        }

        $referer_site = str_replace('www.', '', $referer_site);

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
