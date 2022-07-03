<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Visitor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $ip = $request->ip();

        if ($ip) {
            Visitor::incrementPageViews('/', 'home', $ip);
        }

        $post = Post::query()->where('is_published', true)->latest()->first();

        return view('home', compact('post'));
    }
}
