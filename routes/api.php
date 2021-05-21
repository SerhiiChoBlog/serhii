<?php

use App\Http\Controllers\Api\{SocialShareController, TagController};
use Illuminate\Support\Facades\Route;

Route::post('tags/search/{word}', [TagController::class, 'search']);
Route::post('social-shares/{post}', [SocialShareController::class, 'store']);
