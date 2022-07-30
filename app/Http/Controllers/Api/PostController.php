<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\IndexRequest;
use App\Models\Post;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class PostController extends Controller
{
    public function index(IndexRequest $request): Paginator
    {
        $query = Post::query()
            ->with('tags')
            ->select('id', 'slug', 'title', 'intro', 'image_sm', 'created_at', 'read_time')
            ->where('is_published', true)
            ->latest();

        if ($request->tag) {
            $query = $query->whereHas('tags', fn(Builder $q) => $q->where('name', $request->tag));
        }

        return $query->simplePaginate(10)->appends($request->input());
    }
}
