<?php

use App\Http\Controllers\{AboutMeController,
    Admin\DashboardController,
    PostController,
    ProjectController,
    ThemeController};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::redirect('about', 'about-me');
Route::redirect('blog', 'posts');
Route::redirect('register', 'login');

Route::middleware('hits')->group(function () {
    Route::view('/', 'home')->name('home');
    Route::get('about-me', [AboutMeController::class, 'index'])->name('about-me');

    Route::prefix('posts')->controller(PostController::class)->group(function () {
        Route::get('/', 'index')->name('posts.index');
        Route::get('{post:slug}', 'show')->name('posts.show');
    });

    Route::prefix('projects')->controller(ProjectController::class)->group(function () {
        Route::get('/', 'index')->name('projects.index');
        Route::get('{project:name}', 'show')->name('projects.show');
    });
});

Route::get('theme', ThemeController::class);

Route::view('admin/{any?}', 'layouts.admin')->middleware('auth')->name('admin.dashboard');

Route::middleware('auth')->prefix('ajax')->group(function () {
    Route::get('dashboard/sections', [DashboardController::class, 'sections']);
    // Route::get('page-views', [AdminPageViewController::class, 'index'])->name('page_views.index');
    // Route::get('visitors', [AdminVisitorController::class, 'index'])->name('visitors.index');
    // Route::resource('posts', AdminPostController::class)->except(['show']);
    // Route::resource('tags', AdminTagController::class)->except(['show']);
    // Route::post('post-content-images/{post}', [PostContentImageController::class, 'store'])->name('post-content-images.store');
    // Route::delete('post-content-images/{image}', [PostContentImageController::class, 'destroy'])->name('post-content-images.delete');
    // Route::resource('social-shares', AdminSocialShareController::class)->only(['index']);
    // Route::resource('referrers', ReferrerController::class)->only(['index']);
    // Route::resource('hits', HitController::class)->only(['index']);
});
