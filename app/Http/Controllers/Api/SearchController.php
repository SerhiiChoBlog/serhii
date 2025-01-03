<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Dto\CachablePost;
use App\Http\Controllers\Controller;
use App\Services\SearchPostService;

class SearchController extends Controller
{
    /**
     * @return array<int,CachablePost>
     */
    public function index(string $query): array
    {
        $service = new SearchPostService(strtolower($query));
        return $service->search();
    }
}
