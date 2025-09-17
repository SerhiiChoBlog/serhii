<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Referrer;
use Closure;
use Illuminate\Http\Request;

class ReferrerMiddleware
{
    private const IGNORED_SITES = [
        'serhii.io',
        'serhii.shobar.com.ua',
        'localhost',
    ];

    private const REMOVE_FROM_URL = [
        'www.',
        'http://',
        'https://',
    ];

    public function handle(Request $request, Closure $next): mixed
    {
        $referer_site = request()->headers->get('referer');

        if (!$referer_site || !$request->isMethod('get')) {
            return $next($request);
        }

        $referer_site = str($referer_site)
            ->replace(self::REMOVE_FROM_URL, '')
            ->explode('/')
            ->first();

        if (!$referer_site) {
            return $next($request);
        }

        foreach (self::IGNORED_SITES as $site) {
            if (str_starts_with($referer_site, $site)) {
                return $next($request);
            }
        }

        Referrer::query()->incrementOrCreate(['site' => $referer_site], 'hits');

        return $next($request);
    }
}
