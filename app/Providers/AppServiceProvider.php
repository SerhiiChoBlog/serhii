<?php

namespace App\Providers;

use App\Models\Post;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Blade::if('published', static function (Post $post) {
            return $post->is_published || auth()->check();
        });
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
