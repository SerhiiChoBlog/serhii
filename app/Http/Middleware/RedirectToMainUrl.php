<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectToMainUrl
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (app()->environment('production') === false) {
            return $next($request);
        }

        $url = $request->fullUrl();

        if (str_contains($url, 'http://www.')) {
            $url = str_replace('http://www.', 'https://', $url);
            return redirect($url);
        }

        if (str_contains($url, 'www.')) {
            $url = str_replace('www.', '', $url);
            return redirect($url);
        }

        if (str_contains($url, 'http://')) {
            $url = str_replace('http://', 'https://', $url);
            return redirect($url);
        }

        return $next($request);
    }
}
