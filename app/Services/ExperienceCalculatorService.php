<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\SearchResult;
use DateInterval;
use DateTime;

class ExperienceCalculatorService
{
    public function toSearchResult(): SearchResult
    {
        $diff = $this->getDateDiff()->format("%y years %m months");

        return new SearchResult(
            title: "Serhii Cho's Years of Experience",
            image_url: 'storage/search/experience.jpg',
            url: route('about-me'),
            keywords: [$diff],
            label: 'info',
        );
    }

    private function getDateDiff(): DateInterval
    {
        $started_career = date_create('2017-05-24');
        $current_date = new DateTime();

        return date_diff($started_career, $current_date);
    }
}
