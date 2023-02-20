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
        $post = $event->post;

        if ($post && !$post->is_published) {
            return;
        }

        Cache::forget(CacheKey::RANDOM_POSTS);
        Cache::forget(CacheKey::HOME_POPULAR_POSTS);
    }
}
