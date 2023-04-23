<?php

declare(strict_types=1);

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PostLikeController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\SocialShareController;
use App\Http\Controllers\Api\SubscriptionDemandController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\User\FeedController;
use Illuminate\Support\Facades\Route;

Route::controller(TagController::class)->prefix('tags')->group(function () {
    Route::get('/', 'index');
    Route::get('subscription', 'subscription');
    Route::post('search/{word}', 'search');
});

Route::post('social-shares/{post}', [SocialShareController::class, 'store']);
Route::get('search/{query}', [SearchController::class, 'index']);

Route::post('subscriptions', [SubscriptionDemandController::class, 'subscribe']);

Route::get('posts', [PostController::class, 'index']);
Route::get('related-posts/{post}', [PostController::class, 'related']);

Route::controller(CommentController::class)->prefix('comments')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::post('like', 'like');
});

Route::controller(PostLikeController::class)->prefix('post-likes')->group(function () {
    Route::post('/', 'store');
    Route::get('is-liked', 'isLiked');
});

Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::post('upload-photo', 'uploadPhoto');
});

Route::get('users/feed/{user:slug}', FeedController::class);
