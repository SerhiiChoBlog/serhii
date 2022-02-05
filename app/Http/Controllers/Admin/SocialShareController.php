<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Contracts\View\View;

class SocialShareController extends Controller
{
    public function index(): View
    {
        $posts = Post::query()
            ->with('socialShares')
            ->get()
            ->filter(fn(Post $post) => !empty($post->social));

        return view('admin.social_shares.index', compact('posts'));
    }
}
