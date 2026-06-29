<?php

declare(strict_types=1);

namespace App\Dto;

class DeployRules
{
    public bool $migrate;
    public bool $composer;
    public bool $cache;

    /**
     * @param array{
     *     migrate: bool,
     *     composer: bool,
     *     cache: bool,
     * } $attributes
     */
    public function __construct(array $attributes)
    {
        $this->migrate = $attributes['migrate'];
        $this->composer = $attributes['composer'];
        $this->cache = $attributes['cache'];
    }
}
