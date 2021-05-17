<?php

use App\Http\Controllers\Api\{TagController};
use Illuminate\Support\Facades\Route;

Route::post('tags/search/{word}', [TagController::class, 'search']);
