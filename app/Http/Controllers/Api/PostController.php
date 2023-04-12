<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\IndexRequest;
use App\Models\Post;
use App\Recommendations\Filters\PostSeriesFilter;
use App\Recommendations\Filters\PostTagsFilter;
use App\Recommendations\Filters\ViewedPostsFilter;
use App\Recommendations\RecommendationHandler;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PostController extends Controller
{
    /**
     * @param IndexRequest $request
     *
     * @return Paginator<Post>
     */
    public function index(IndexRequest $request): Paginator
    {
        $query = Post::query()
            ->with('tags')
            ->select('id', 'slug', 'title', 'intro', 'image_sm', 'created_at', 'read_time')
            ->where('is_published', true)
            ->latest();

        if ($request->tag) {
            $query = $query->whereHas('tags', fn (Builder $q) => $q->where('name', $request->tag));
        }

        return $query->simplePaginate(10)->appends($request->input());
    }

    /**
     * @return Collection<int, Post>
     */
    public function related(Post $post): Collection
    {
        return (new RecommendationHandler(3))
            ->useFilter(new PostSeriesFilter($post))
            ->useFilter(new PostTagsFilter($post))
            ->useFilter(new ViewedPostsFilter())
            ->get();
    }
}
