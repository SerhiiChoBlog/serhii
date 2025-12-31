<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Dto\SearchResult;
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
            array_push($result, $exp);
        } else if (preg_match('/^ser(h?|hi?|hii?)$/', $query)) {
            array_push($result, new SearchResult(
                title: 'Serhii Cho',
                url: url('@serhii-cho'),
                image_url: 'storage/search/serhii-cho.jpg',
                keywords: ['Profile page'],
                label: 'user',
            ));
        }

        $search_posts_service = new SearchPostService($query);

        $result = array_merge($result, $search_posts_service->search());

        return $result;
    }
}
