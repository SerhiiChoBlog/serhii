<?php

declare(strict_types=1);

use App\Http\Middleware\RedirectIfAuthenticated as CustomRedirectIfAuthenticated;
use App\Http\Middleware\ReferrerMiddleware;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders()
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->encryptCookies(except: ['theme']);
        $middleware->preventRequestForgery(except: [
            '/admin/ajax/post-content-images/*',
            '/admin/ajax/posts/*',
        ]);

        $middleware->api('throttle:api');

        $middleware->web(
            append: [
                ReferrerMiddleware::class,
            ],
            replace: [RedirectIfAuthenticated::class => CustomRedirectIfAuthenticated::class],
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
