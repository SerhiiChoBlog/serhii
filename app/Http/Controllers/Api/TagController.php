<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Support\Collection;

class TagController extends Controller
{
    /**
     * @return Collection<int, Tag>
     */
    public function index(): Collection
    {
        return Tag::query()->has('posts')->get();
    }

    /**
     * @param string $word
     *
     * @return Collection<int, Tag>
     */
    public function search(string $word): Collection
    {
        return Tag::query()
            ->where('name', 'LIKE', "%$word%")
            ->get();
    }

    /**
     * @return Collection<int, Tag>
     */
    public function popular(): Collection
    {
        return Tag::query()
            ->withCount('posts')
            ->orderByDesc('posts_count')
            ->limit(5)
            ->get();
    }
}
