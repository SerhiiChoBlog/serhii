<?php

use App\Http\Controllers\Api\{PostController, SearchController, SocialShareController, TagController};
use Illuminate\Support\Facades\Route;

Route::controller(TagController::class)->prefix('tags')->group(function () {
    Route::get('/', 'index');
    Route::post('search/{word}', 'search');
    Route::get('popular', 'popular');
});

Route::post('social-shares/{post}', [SocialShareController::class, 'store']);
Route::get('search/{query}', [SearchController::class, 'index']);

Route::get('posts', [PostController::class, 'index']);
