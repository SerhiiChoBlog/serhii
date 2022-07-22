<?php

use App\Http\Controllers\Api\{SearchController, SocialShareController, TagController};
use Illuminate\Support\Facades\Route;

Route::post('tags/search/{word}', [TagController::class, 'search']);
Route::get('tags/popular', [TagController::class, 'popular']);

Route::post('social-shares/{post}', [SocialShareController::class, 'store']);
Route::get('search/{query}', [SearchController::class, 'index']);
