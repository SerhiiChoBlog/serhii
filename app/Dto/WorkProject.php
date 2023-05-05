<?php

declare(strict_types=1);

namespace App\Dto;

class WorkProject
{
    /**
     * @param array<int, string> $technologies
     */
    public function __construct(
        public string $image_uri,
        public string $title,
        public string $subtitle,
        public string $content,
        public string $link,
        public array $technologies,
    ) {
    }
}
