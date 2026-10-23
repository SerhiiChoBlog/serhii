<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\CacheKey;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Keyword\DestroyRequest;
use App\Http\Requests\Admin\Keyword\StoreRequest;
use App\Models\Keyword;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class KeywordController extends Controller
{
    public function store(StoreRequest $request): void
    {
        /** @var Keyword|null $keyword */
        $keyword = Keyword::query()
            ->where('name', $request->name)
            ->first();

        if (!$keyword) {
            $keyword = Keyword::query()->create(['name' => $request->name]);
        }

        $keyword_exists = Post::query()
            ->where('id', $request->post_id)
            ->whereHas('keywords', fn ($q) => $q->where('keywords.id', $keyword->id))
            ->exists();

        if ($keyword_exists) {
            return;
        }

        $keyword->posts()->attach($request->post_id);

        Cache::forget(CacheKey::POSTS_SEARCH);
    }

    public function destroy(DestroyRequest $request): void
    {
        /** @var Post $post */
        $post = Post::query()->findOrFail($request->post_id);
        $post->keywords()->detach($request->keyword_id);

        Cache::forget(CacheKey::POSTS_SEARCH);
    }
}
