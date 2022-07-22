<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Visitor;
use HttpException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::query()
            ->with('tags:id,name,color')
            ->select('id', 'slug', 'title', 'intro', 'image_sm', 'created_at', 'read_time')
            ->where('is_published', true)
            ->latest()
            ->paginate(15);

        return view('posts.index', compact('posts'));
    }

    /**
     * @throws HttpException
     */
    public function show(string $slug, Request $request): View
    {
        /** @var Post | null */
        $post = Post::query()
            ->with('tags:id,color,name')
            ->where('slug', $slug)
            ->withCount('pageViews')
            ->first();

        abort_if(!$post || (!$post->is_published && !Auth::check()), 404);

        /** @var int<0, 190> $title_len */
        $title_len = strlen($post->title);

        $title_font_size = match (true) {
            $title_len <= 10 => '5em',
            $title_len < 20 => '4.6em',
            $title_len < 30 => '4.2em',
            $title_len < 40 => '3.6em',
            $title_len < 50 => '3.2em',
            $title_len < 60 => '3em',
            $title_len < 70 => '2.6em',
            default => '2em',
        };

        $posts = Post::getPostsForSidebar($post->id);
        $segment = $request->segment(2);
        $ip = $request->ip();

        if (!$segment || !$ip) {
            throw new HttpException('Incorrect url path or IP address of the client');
        }

        Visitor::incrementPageViews($segment, 'post', $ip);

        return view('posts.show', compact('post', 'title_font_size', 'posts'));
    }
}
