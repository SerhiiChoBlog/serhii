<?php

declare(strict_types=1);

namespace App;

abstract class CacheKey
{
    public const PUBLISHED_POSTS = 'published-posts';
    public const POST = 'post:';
    public const PROJECTS = 'projects';
}
