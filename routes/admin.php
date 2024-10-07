<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\BanController;
use App\Http\Controllers\Admin\BookAuthorController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KeywordController;
use App\Http\Controllers\Admin\PostContentImageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PostPublicationController;
use App\Http\Controllers\Admin\PostViewController;
use App\Http\Controllers\Admin\ReferrerController;
use App\Http\Controllers\Admin\SeriesController;
use App\Http\Controllers\Admin\SocialShareController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VisitorController;
use Illuminate\Support\Facades\Route;

Route::prefix('ajax')->name('admin.')->group(function () {
    Route::get('dashboard/sections', [DashboardController::class, 'sections']);
    Route::get('dashboard/goals', [DashboardController::class, 'goals']);
    Route::resource('posts', PostController::class);
    Route::post('post-content-images/{post}', [PostContentImageController::class, 'store']);
    Route::delete('post-content-images/{image}', [PostContentImageController::class, 'destroy']);
    Route::resource('tags', TagController::class)->except('show', 'create');
    Route::resource('post-views', PostViewController::class)->only('index');
    Route::resource('social-shares', SocialShareController::class)->only('index');
    Route::resource('referrers', ReferrerController::class)->only('index');
    Route::resource('post-publications', PostPublicationController::class)->only('index');

    Route::prefix('books')->controller(BookController::class)->group(function () {
        Route::put('{book}/update-field', 'updateField');
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::delete('{book}', 'destroy');
    });

    Route::get('series/names', [SeriesController::class, 'names']);
    Route::resource('series', SeriesController::class)->except('show', 'create');

    Route::prefix('visitors')->controller(VisitorController::class)->group(function () {
        Route::get('/', [VisitorController::class, 'index']);
        Route::post('{visitor}/block', 'block');
        Route::post('{visitor}/unblock', 'unblock');
    });

    Route::prefix('users')->controller(UserController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('{user}', 'show');
    });

    Route::prefix('bans')->controller(BanController::class)->group(function () {
        Route::post('ban', 'ban');
        Route::post('unban', 'unban');
    });

    Route::prefix('keywords')->controller(KeywordController::class)->group(function () {
        Route::post('/', 'store');
        Route::delete('/', 'destroy');
    });

    Route::prefix('book-authors')->controller(BookAuthorController::class)->group(function () {
        Route::get('search/{author}', 'search');
        Route::post('/', 'store');
    });

    Route::prefix('comments')->controller(CommentController::class)->group(function () {
        Route::get('/', 'index');
        Route::put('approve/{comment}', 'approve');
        Route::put('disapprove/{comment}', 'disapprove');
        Route::delete('delete-all/{user}', 'destroyAll');
        Route::delete('{comment}', 'destroy');
    });
});

Route::view('{any?}', 'layouts.admin')
    ->where('any', '.*');
