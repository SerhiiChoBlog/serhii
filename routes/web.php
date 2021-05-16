<?php

use App\Http\Controllers\Admin\{DashboardController as AdminDashboardController,
    PageViewController as AdminPageViewController,
    PostController as AdminPostController,
    TagController as AdminTagController,
    VisitorController as AdminVisitorController,};
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::view('/', 'home')->name('home');
Route::redirect('/register', 'login');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('page-views', [AdminPageViewController::class, 'index'])->name('admin.page_views.index');
    Route::get('visitors', [AdminVisitorController::class, 'index'])->name('admin.visitors.index');
    Route::resource('posts', AdminPostController::class)->except(['show']);
    Route::resource('tags', AdminTagController::class)->except(['show', 'create']);
});

Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
