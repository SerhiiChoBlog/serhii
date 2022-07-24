<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('ajax')->name('admin.')->middleware('auth')->group(function () {
    Route::get('dashboard/sections', [DashboardController::class, 'sections']);
    Route::resource('posts', PostController::class)->only('index', 'store', 'update', 'edit');
    // Route::get('page-views', [PageViewController::class, 'index'])->name('page_views.index');
    // Route::get('visitors', [VisitorController::class, 'index'])->name('visitors.index');
    // Route::resource('tags', TagController::class)->except(['show']);
    // Route::post('post-content-images/{post}', [PostContentImageController::class, 'store'])->name('post-content-images.store');
    // Route::delete('post-content-images/{image}', [PostContentImageController::class, 'destroy'])->name('post-content-images.delete');
    // Route::resource('social-shares', SocialShareController::class)->only(['index']);
    // Route::resource('referrers', ReferrerController::class)->only(['index']);
    // Route::resource('hits', HitController::class)->only(['index']);
});

Route::view('{any}', 'layouts.admin')
    ->middleware('auth')
    ->name('admin.dashboard')
    ->where('any', '.*');
