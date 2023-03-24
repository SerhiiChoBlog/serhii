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
        return Tag::query()
            ->withCount('posts')
            ->orderByDesc('posts_count')
            ->get();
    }

    /**
     * @return Collection<int, Tag>
     */
    public function subscription(): Collection
    {
        return Tag::query()
            ->withCount('posts')
            ->whereNotIn('name', [
                'react',
                'html',
                'story',
            ])
            ->orderByDesc('posts_count')
            ->get();
    }

    /**
     * @param string $word
     *
     * @return Collection<int, Tag>
     */
    public function search(string $word): Collection
    {
        return Tag::query()
            ->where('name', 'LIKE', "%{$word}%")
            ->get();
    }
}
