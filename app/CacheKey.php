<?php

declare(strict_types=1);

namespace App;

abstract class CacheKey
{
    public const POST = 'post:';
    public const PROJECTS = 'projects';
    public const LAST_POSTS = 'last-posts';
}
