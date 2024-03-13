<?php

declare(strict_types=1);

use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\RedirectToMainUrl;
use App\Http\Middleware\ReferrerMiddleware;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders()
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
    )
    ->withMIddleware(function (Middleware $middleware) {
        VerifyCsrfToken::except([
            '/admin/ajax/post-content-images/*',
            '/admin/ajax/posts/*',
        ]);

        EncryptCookies::except(['theme']);

        $middleware->web(RedirectIfAuthenticated::class);
        $middleware->web(RedirectToMainUrl::class);
        $middleware->web(ReferrerMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
