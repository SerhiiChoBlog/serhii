<?php

declare(strict_types=1);

namespace App\AvatarGenerators;

interface AvatarGenerator
{
    public function __construct(string $email);

    public function generate(): string|null;
}
