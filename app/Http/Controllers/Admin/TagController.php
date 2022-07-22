<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(): View
    {
        $tags = Tag::query()
            ->withCount('posts')
            ->orderByDesc('posts_count')
            ->get();

        return view('admin.tags.index', compact('tags'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['name' => 'required']);
        Tag::query()->create($request->all());
        return redirect()->route('admin.tags.index');
    }

    public function edit(Tag $tag): View
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function create(): View
    {
        return view('admin.tags.create');
    }

    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $tag->update($request->all());
        return redirect()->route('admin.tags.index');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();
        return redirect()->route('admin.tags.index');
    }
}
