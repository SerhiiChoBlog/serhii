<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HitController;
use App\Http\Controllers\Admin\PageViewController;
use App\Http\Controllers\Admin\PostContentImageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\VisitorController;
use Illuminate\Support\Facades\Route;

Route::prefix('ajax')->name('admin.')->middleware('auth')->group(function () {
    Route::get('dashboard/sections', [DashboardController::class, 'sections']);
    Route::resource('posts', PostController::class);
    Route::post('post-content-images/{post}', [PostContentImageController::class, 'store']);
    Route::delete('post-content-images/{image}', [PostContentImageController::class, 'destroy']);
    Route::resource('tags', TagController::class)->except('show', 'create');
    Route::resource('page-views', PageViewController::class)->only('index');
    Route::resource('visitors', VisitorController::class)->only('index');
    // Route::resource('social-shares', SocialShareController::class)->only('index');
    // Route::resource('referrers', ReferrerController::class)->only('index');
    Route::resource('hits', HitController::class)->only('index');
});

Route::view('{any?}', 'layouts.admin')
    ->middleware('auth')
    ->name('admin.dashboard')
    ->where('any', '.*');
