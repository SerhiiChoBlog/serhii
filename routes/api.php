<?php

use App\Http\Controllers\Api\{PageViewController, ProjectController, TagController};
use Illuminate\Support\Facades\Route;

Route::get('projects', [ProjectController::class, 'index']);
Route::post('page-view/update', [PageViewController::class, 'update']);

Route::post('tags/search/{word}', [TagController::class, 'search']);
