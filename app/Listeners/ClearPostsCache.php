<?php

declare(strict_types=1);

namespace App\Listeners;

use App\CacheKey;
use App\Events\PostChanged;
use Illuminate\Support\Facades\Cache;

class ClearPostsCache
{
    public function handle(PostChanged $event): void
    {
        Cache::forget(CacheKey::RANDOM_POSTS);
        Cache::forget(CacheKey::HOME_POPULAR_POSTS);
        Cache::forget(CacheKey::POSTS_SEARCH);
        Cache::forget(CacheKey::HOME_SEARCH_TAGS);
        Cache::forget(CacheKey::LATEST_POSTS);
        Cache::forget(CacheKey::UPCOMING);
    }
}
