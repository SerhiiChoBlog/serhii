<?php

declare(strict_types=1);

namespace App\Dto;

readonly class SearchResult
{
    /**
     * @param list(string) $keywords
     */
    public function __construct(
        public string $title,
        public string $url,
        public string $image_url,
        public array $keywords,
        public string $label,
    ) {
    }
}
