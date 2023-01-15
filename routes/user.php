<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::view('{any?}', 'layouts.user')
    ->middleware('user')
    ->name('user.profile')
    ->where('any', '.*');
