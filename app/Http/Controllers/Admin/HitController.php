<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hit;
use Illuminate\Contracts\View\View;

class HitController extends Controller
{
    public function index(): View
    {
        $hits = Hit::query()->latest()->paginate(30);
        return view('admin.hits.index', compact('hits'));
    }
}
