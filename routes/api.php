<?php

use App\Http\Controllers\Api\{PageViewController, PostController, ProjectController, TagController};
use Illuminate\Support\Facades\Route;

Route::get('projects', [ProjectController::class, 'index']);
Route::post('page-view/update', [PageViewController::class, 'update']);

Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{post}', [PostController::class, 'show']);

Route::post('tags/search/{word}', [TagController::class, 'search']);
