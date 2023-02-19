<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Utils\GlobalVisitor;
use Closure;
use Illuminate\Http\Request;

class PreventBlockedVisitor
{
    public function handle(Request $request, Closure $next): mixed
    {
        GlobalVisitor::getInstance()->load();
        return $next($request);
    }
}
