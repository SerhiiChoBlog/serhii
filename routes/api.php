<?php

use App\Http\Controllers\Api\{NewPostController, SocialShareController, TagController};
use Illuminate\Support\Facades\Route;

Route::post('tags/search/{word}', [TagController::class, 'search']);
Route::post('social-shares/{post}', [SocialShareController::class, 'store']);

Route::get('new-post', NewPostController::class);
