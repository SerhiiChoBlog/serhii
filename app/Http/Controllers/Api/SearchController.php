<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    /**
     * @param string $query
     *
     * @return Collection<int, Post>
     */
    public function index(string $query): Collection
    {
        return Post::query()
            ->select('id', 'title', 'slug', 'image_sm')
            ->with('tags')
            ->where(static function (Builder $q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhereHas('tags', static function (Builder $q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%");
                    })
                    ->orWhereHas('keywords', static function (Builder $q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%");
                    });
            })
            ->where('is_published', true)
            ->limit(5)
            ->get();
    }
}
