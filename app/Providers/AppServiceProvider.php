<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for('api', static fn (Request $request) => [
            Limit::perSecond(100),
            Limit::perMinute(1000),
        ]);

        Model::preventLazyLoading();
        Model::preventAccessingMissingAttributes();

        Schema::defaultStringLength(191);
    }
}
