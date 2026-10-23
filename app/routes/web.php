<?php

declare(strict_types=1);

use App\Http\Controllers\AboutMeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('@{user:slug}', [UserController::class, 'show'])->name('users.show');

Route::redirect('about', 'about-me');
Route::redirect('blog', 'posts');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('about-me', [AboutMeController::class, 'index'])->name('about-me');

Route::prefix('posts')->controller(PostController::class)->group(function () {
    Route::get('/', 'index')->name('posts.index');
    Route::get('{post:slug}', 'show')->name('posts.show');
});

Route::prefix('series')->controller(SeriesController::class)->group(function () {
    Route::get('/', 'index')->name('series.index');
    Route::get('{series:slug}', 'show')->name('series.show');
});

Route::prefix('projects')->controller(ProjectController::class)->group(function () {
    Route::get('/', 'index')->name('projects.index');
    Route::get('{project:name}', 'show')->name('projects.show');
});

Route::view('subscribe', 'subscribe')->name('subscribe');

Route::prefix('subscriptions')->controller(SubscriptionController::class)->group(function () {
    Route::get('confirm/{slug}', 'confirm')->name('subscriptions.confirm');
    Route::get('decline/{slug}', 'decline')->name('subscriptions.decline');
    Route::get('unsubscribe/{slug}', 'unsubscribe')->name('subscriptions.unsubscribe');
    Route::view('error', 'subscriptions.error')->name('subscriptions.error');
});

Route::get('theme/{to}', ThemeController::class);
