<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function index(string $query): array
    {
        //
        return ['query' => $query];
    }
}
