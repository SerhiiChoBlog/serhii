<?php

namespace App\View\Components\Home;

use App\CacheKey;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class LastPost extends Component
{
    public array $post;

    public function __construct()
    {
        $this->post = $this->getLastPost();
    }

    public function render(): View
    {
        return view('components.home.last-post');
    }

    public function getLastPost(): array
    {
        return Cache::rememberForever(CacheKey::LAST_POST, static function () {
            return Post::query()
                ->select('id', 'image_sm', 'title', 'intro', 'slug')
                ->where('is_published', true)
                ->latest()
                ->first()
                ?->toArray();
        });
    }
}
