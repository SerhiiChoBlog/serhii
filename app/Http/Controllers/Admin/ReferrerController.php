<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referrer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReferrerController extends Controller
{
    /**
     * @return LengthAwarePaginator<Referrer>
     */
    public function index(): LengthAwarePaginator
    {
        return Referrer::query()
            ->orderByDesc('hits')
            ->paginate(30);
    }
}
