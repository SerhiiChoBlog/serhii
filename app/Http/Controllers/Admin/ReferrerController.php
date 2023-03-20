<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referrer;
use Illuminate\Support\Collection;

class ReferrerController extends Controller
{
    /**
     * @return Collection<int, Referrer>
     */
    public function index(): Collection
    {
        return Referrer::query()->orderByDesc('hits')->get();
    }
}
