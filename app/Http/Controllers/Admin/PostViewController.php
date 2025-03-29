<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostView;
use Illuminate\Support\Collection;

class PostViewController extends Controller
{
    /**
     * @return array{
     *    unique: array<int, array<string, mixed>>,
     *    daily: Collection<int, PostView>,
     * }
     */
    public function index(): array
    {
        $unique = [];

        $unique_from_db = PostView::query()
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

        foreach ($unique_from_db as $unique_item) {
            $unique[] = [
                'amount' => $unique_item->amount,
                'post_id' => $unique_item->post_id,
                'post' => Post::query()
                    ->select('id', 'title', 'image_sm', 'created_at')
                    ->where('id', $unique_item->post_id)
                    ->first(),
            ];
        }

        return compact('unique', 'daily');
    }
}
