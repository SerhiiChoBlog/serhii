<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for('api', static fn () => [
            Limit::perSecond(100),
            Limit::perMinute(1000),
        ]);

        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Model::preventLazyLoading();
        Model::preventAccessingMissingAttributes();

        Schema::defaultStringLength(191);
    }
}
