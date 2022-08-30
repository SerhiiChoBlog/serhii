<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use App\Models\Post;
use App\Models\PostView;
use Illuminate\Support\Collection;

class PostViewController extends Controller
{
    /**
     * @return array{unique:Collection<int, PageView>, daily:Collection<int, PageView>}
     */
    public function index(): array
    {
        $unique = PostView::query()
            ->selectRaw('post_id, COUNT(*) as amount')
            ->groupBy('post_id')
            ->orderByDesc('amount')
            ->limit(50)
            ->get();

        $daily = PostView::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as amount')
            ->groupBy('date')
            ->orderByDesc('date')
            ->limit(50)
            ->get();

        $unique = $unique->map(function ($item) {
            $item->post = Post::query()
                ->select('id', 'title', 'image_sm')
                ->where('id', $item->post_id)
                ->first();

            return $item;
        });

        return compact('unique', 'daily');
    }
}
