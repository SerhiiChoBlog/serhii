<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\SocialShare;
use Illuminate\Support\Collection;

class SocialShareController extends Controller
{
    /**
     * @return Collection<int, Post>
     */
    public function index(): Collection
    {
        return Post::query()->with('socialShares')->get()->map(static function (Post $post) {
            $post->social = $post->socialShares->groupBy(function (SocialShare $socialShare) {
                return $socialShare->social->value;
            })->toArray();

            return $post;
        })->filter(fn (Post $post) => !empty($post->social));
    }
}
