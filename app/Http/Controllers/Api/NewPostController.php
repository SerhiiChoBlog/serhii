<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;

class NewPostController extends Controller
{
    public function __invoke(): ?Post
    {
        return Post::query()
            ->select('title', 'image_sm', 'created_at')
            ->where('is_published', false)
            ->first();
    }
}
