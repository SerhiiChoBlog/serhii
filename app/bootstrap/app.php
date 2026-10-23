<?php

declare(strict_types=1);

use App\Http\Middleware\RedirectIfAuthenticated as CustomRedirectIfAuthenticated;
use App\Http\Middleware\ReferrerMiddleware;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Session\Middleware\StartSession;

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

        $middleware->api(
            prepend: [
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                PreventRequestForgery::class,
            ],
            append: ['throttle:api'],
        );

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
