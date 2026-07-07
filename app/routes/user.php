<?php

declare(strict_types=1);

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function () {
    Route::get('profile', 'profile')->name('profile');
    Route::view('settings', 'users.settings')->name('settings');
    Route::delete('/', 'destroy')->name('delete');
});
