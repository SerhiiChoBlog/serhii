<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\CacheKey;
use App\Models\Post;
use App\Models\Visitor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $ip = $request->ip();

        if ($ip) {
            Visitor::incrementPageViews('/', 'home', $ip);
        }

        $post = Cache::rememberForever(CacheKey::LAST_POST, static function () {
            return Post::query()->where('is_published', true)->latest()->first();
        });

        return view('home', compact('post'));
    }
}
