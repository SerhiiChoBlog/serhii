<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if ($guard === 'admin' && Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::ADMIN_HOME);
            }

            if ($guard === 'user' && Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::USER_HOME);
            }
        }

        return $next($request);
    }
}
