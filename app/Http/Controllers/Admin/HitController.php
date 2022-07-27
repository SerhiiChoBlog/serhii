<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hit;
use Illuminate\Support\Collection;

class HitController extends Controller
{
    /**
     * @return Collection<int, Hit>
     */
    public function index(): Collection
    {
        return Hit::query()
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();
    }
}
