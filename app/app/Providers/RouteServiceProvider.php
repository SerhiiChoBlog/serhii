<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const ADMIN_HOME = '/admin/dashboard';
    public const USER_HOME = '/users/profile';

    public function boot(): void
    {
        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::prefix('admin')
                ->middleware(['web', 'auth:admin'])
                ->namespace($this->namespace)
                ->group(base_path('routes/admin.php'));

            Route::prefix('users')
                ->name('users.')
                ->middleware(['web', 'auth:user', 'verified'])
                ->namespace($this->namespace)
                ->group(base_path('routes/user.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }
}
