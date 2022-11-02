<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\SocialShareController;
use App\Http\Controllers\Api\SubscriptionDemandController;
use App\Http\Controllers\Api\TagController;
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
