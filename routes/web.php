<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::view('/', 'welcome');
Route::redirect('register', 'login');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index']);
});
