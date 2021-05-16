<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::query()->with('tags')->get();
        return view('posts.index', compact('posts'));
    }

    public function show(): View
    {
        return view('posts.show');
    }
}
