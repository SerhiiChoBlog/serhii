<?php

use App\Http\Controllers\{AboutMeController, HomeController, PostController, ProjectController, ThemeController,};
use App\Http\Controllers\Admin\{DashboardController as AdminDashboardController,
    PageViewController as AdminPageViewController,
    PostContentImageController,
    PostController as AdminPostController,
    SocialShareController as AdminSocialShareController,
    TagController as AdminTagController,
    VisitorController as AdminVisitorController,};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::redirect('about', 'about-me');
Route::redirect('blog', 'posts');

Route::redirect('/register', 'login');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-me', [AboutMeController::class, 'index'])->name('about-me');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('page-views', [AdminPageViewController::class, 'index'])->name('page_views.index');
    Route::get('visitors', [AdminVisitorController::class, 'index'])->name('visitors.index');
    Route::resource('posts', AdminPostController::class)->except(['show']);
    Route::resource('tags', AdminTagController::class)->except(['show', 'create']);
    Route::post('post-content-images/{post}', [PostContentImageController::class, 'store'])->name('post-content-images.store');
    Route::delete('post-content-images/{image}', [PostContentImageController::class, 'destroy'])->name('post-content-images.delete');
    Route::resource('social-shares', AdminSocialShareController::class)->only(['index']);
});

Route::prefix('posts')->controller(PostController::class)->group(function () {
    Route::get('/', 'index')->name('posts.index');
    Route::get('{post:slug}', 'show')->name('posts.show');
});

Route::prefix('projects')->controller(ProjectController::class)->group(function () {
    Route::get('/', 'index')->name('projects.index');
    Route::get('{project:name}', 'show')->name('projects.show');
});

Route::get('theme', ThemeController::class);
