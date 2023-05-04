<?php

declare(strict_types=1);

namespace App\Dto;

use InvalidArgumentException;

class Testimonial
{
    public function __construct(
        public string $image_uri,
        public string $name,
        public string $role,
        public string $content,
        public string|null $short = null,
    ) {
        $this->validateImageUri();
    }

    private function validateImageUri(): void
    {
        if (!filter_var($this->image_uri, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid image URI');
        }
    }
}
