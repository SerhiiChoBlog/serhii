<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewPostController extends Controller
{
    public function __invoke(Request $request): ?array
    {
        $post = $this->getPost();

        if (!$post) {
            return null;
        }

        $date = $post->published_at->timestamp;
        $remaining = $date - time();

        $days_remaining = floor($remaining / 86400);
        $hours_remaining = floor(($remaining % 86400) / 3600);

        $days = Str::plural('day', $days_remaining);
        $days_string = $days_remaining === 0.0 ? '' : "$days_remaining $days ";

        return [
            'countdown' => "{$days_string}{$hours_remaining} hours",
            'title' => $post->title,
        ];
    }

    public function getPost(): ?Post
    {
        return Post::query()->where('is_published', false)->whereNotNull('published_at')->first();
    }
}
