<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostPublication;
use Illuminate\Support\Collection;

class PostPublicationController extends Controller
{
    /**
     * @return Collection<int, PostPublication>
     */
    public function index(): Collection
    {
        return PostPublication::with('post')
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();
    }
}
