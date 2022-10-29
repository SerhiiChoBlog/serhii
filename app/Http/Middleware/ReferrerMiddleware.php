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
        if (!$request->isMethod('get') || $request->missing('welcome')) {
            return $next($request);
        }

        $hash = $request->get('welcome');

        Referrer::query()->where('hash', $hash)->increment('hits');

        $new_url = $request->fullUrlWithoutQuery('welcome');

        return redirect()->to($new_url);
    }
}
