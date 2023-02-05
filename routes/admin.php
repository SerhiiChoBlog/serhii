<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HitController;
use App\Http\Controllers\Admin\PostContentImageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PostPublicationController;
use App\Http\Controllers\Admin\PostViewController;
use App\Http\Controllers\Admin\SocialShareController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VisitorController;
use App\Http\Controllers\ReferrerController;
use Illuminate\Support\Facades\Route;

Route::prefix('ajax')->name('admin.')->group(function () {
    Route::get('dashboard/sections', [DashboardController::class, 'sections']);
    Route::resource('posts', PostController::class);
    Route::post('post-content-images/{post}', [PostContentImageController::class, 'store']);
    Route::delete('post-content-images/{image}', [PostContentImageController::class, 'destroy']);
    Route::resource('tags', TagController::class)->except('show', 'create');
    Route::resource('post-views', PostViewController::class)->only('index');
    Route::resource('visitors', VisitorController::class)->only('index');
    Route::resource('social-shares', SocialShareController::class)->only('index');
    Route::resource('referrers', ReferrerController::class)->only('index');
    Route::resource('hits', HitController::class)->only('index');
    Route::resource('post-publications', PostPublicationController::class)->only('index');
    Route::resource('users', UserController::class)->only('index');
});

Route::view('{any?}', 'layouts.admin')
    ->where('any', '.*');
