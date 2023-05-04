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
        public string|null $link = null,
        public string|null $short = null,
    ) {
        $this->validateImageUri();
    }

    private function validateImageUri(): void
    {
        if (!str_starts_with($this->image_uri, '/storage/testimonials/')) {
            throw new InvalidArgumentException('Invalid image URI');
        }
    }
}
