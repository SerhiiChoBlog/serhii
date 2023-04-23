<?php

declare(strict_types=1);

namespace App\Dto;

use App\Enums\FeedType;

readonly class FeedItem
{
    public function __construct(
        public int $id,
        public string $title,
        public string $content,
        public FeedType $type,
        public string $date,
    ) {
    }
}
