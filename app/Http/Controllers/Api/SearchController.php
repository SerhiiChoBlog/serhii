<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SearchPostService;
use App\Services\ExperienceCalculatorService;

class SearchController extends Controller
{
    /**
     * @return list(SearchResult)
     */
    public function index(string $query): array
    {
        $query = strtolower($query);
        $result = [];

        if (preg_match('/^exp$/i', $query)) {
            $exp = (new ExperienceCalculatorService())->toSearchResult();
            $result = array_merge($result, $exp);
        }

        $search_posts_service = new SearchPostService($query);

        $result = array_merge($result, $search_posts_service->search());

        return $result;
    }
}
