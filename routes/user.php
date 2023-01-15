<?php

declare(strict_types=1);

use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('user')->group(function () {
    Route::get('profile', [ProfileController::class, 'show'])->name('user.profile.show');
});
