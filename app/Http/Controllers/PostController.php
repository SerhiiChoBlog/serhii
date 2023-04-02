<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Post\IndexRequest;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Visitor;
use HttpException;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(IndexRequest $request): View
    {
        $query = Post::with('tags:id,name,color,title')
            ->with([
                'series' => function (BelongsToMany $q) {
                    return $q->select('id', 'title', 'slug')->withCount('posts');
                },
            ])
            ->select('id', 'slug', 'title', 'intro', 'image_sm', 'image_xs', 'created_at', 'read_time')
            ->withCount('comments')
            ->withCount('postViews')
            ->where('is_published', true)
            ->latest();

        if ($request->tag) {
            $query = $query->whereHas('tags', fn (Builder $q) => $q->where('name', $request->tag));
        }

        return view('posts.index', [
            'posts' => $query->paginate(15),
            'tag' => $request->tag ? Tag::query()->where('name', $request->tag)->first() : null,
        ]);
    }

    /**
     * @throws HttpException
     */
    public function show(string $slug, Request $request): View
    {
        /** @var Post|null $post */
        $post = Post::with('tags')
            ->with('video:post_id,title,url,image')
            ->with([
                'series' => function (BelongsToMany $q) {
                    return $q->select('id', 'title', 'slug', 'color_from', 'color_to')
                        ->withCount('posts');
                },
            ])
            ->withCount('comments')
            ->where('slug', $slug)
            ->withCount('postViews')
            ->first();

        if (!$post) {
            abort(404, 'Post not found');
        }

        if (!$post->is_published && !auth('admin')->check()) {
            abort(404, 'Post not found');
        }

        $title_len = strlen($post->title);

        if ($post->series->isNotEmpty()) {
            $title_len += strlen($post->series->first()->title ?? '') + 2;
        }

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

        Visitor::incrementPostViews($post->id);

        return view('posts.show', compact('post', 'title_font_size'));
    }
}
