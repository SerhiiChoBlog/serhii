<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Dto\SearchResult;
use App\Http\Controllers\Controller;
use App\Services\SearchPostService;

class SearchController extends Controller
{
    /**
     * @return array<int,SearchResult>
     */
    public function index(string $query): array
    {
        $query = strtolower($query);
        $service = new SearchPostService($query);
        return $service->search();
    }
}
