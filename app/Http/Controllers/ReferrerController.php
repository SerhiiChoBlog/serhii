<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Referrer;
use Illuminate\Contracts\View\View;

class ReferrerController extends Controller
{
    public function index(): View
    {
        $referrers = Referrer::query()->orderByDesc('hits')->get();
        return view('admin.referrers.index', compact('referrers'));
    }
}
