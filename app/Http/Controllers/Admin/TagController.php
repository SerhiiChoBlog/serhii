<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
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

    public function store(Request $request): void
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'description' => 'required',
            'color' => 'required',
        ]);

        Tag::query()->create($request->all());
    }

    public function edit(Tag $tag): Tag
    {
        return $tag;
    }

    public function update(Request $request, Tag $tag): void
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'description' => 'required',
            'color' => 'required',
        ]);

        $tag->update($request->all());
    }

    public function destroy(Tag $tag): void
    {
        $tag->delete();
    }
}
