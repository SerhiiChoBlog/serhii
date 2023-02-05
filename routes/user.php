<?php

declare(strict_types=1);

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('ajax')->name('user.')->group(function () {
    Route::get('users/{user:slug?}', [UserController::class, 'show']);
});

Route::view('{any?}', 'layouts.user')
    ->where('any', '.*');
