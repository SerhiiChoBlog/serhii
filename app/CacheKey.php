<?php

declare(strict_types=1);

namespace App;

abstract class CacheKey
{
    public const PROJECTS = 'projects';
    public const LAST_POSTS = 'last-posts';
    public const RANDOM_POSTS = 'random-posts';
}
