<?php

declare(strict_types=1);

namespace App\Dto;

class DeployRules
{
    public bool $migrate;
    public bool $composer;

    public function __construct(array $attributes)
    {
        $this->migrate = $attributes['migrate'];
        $this->composer = $attributes['composer'];
    }
}
