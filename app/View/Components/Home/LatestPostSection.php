<?php

namespace App\View\Components\Home;

use App\CacheKey;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class LatestPostSection extends Component
{
    public ?array $post;

    public function __construct()
    {
        $this->post = $this->getPost();
    }

    public function getPost(): ?array
    {
        return Cache::rememberForever(CacheKey::LAST_POST, static function () {
            return Post::query()
                ->with('tags:name,color')
                ->select('id', 'slug', 'title', 'intro', 'image_sm', 'created_at')
                ->where('is_published', true)
                ->latest()
                ->first()
                ?->toArray();
        });
    }

    public function render(): View
    {
        return view('components.home.latest-post-section');
    }
}
