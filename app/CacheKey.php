<?php

declare(strict_types=1);

namespace App;

abstract class CacheKey
{
    public const PROJECTS = 'projects';
    public const RANDOM_POSTS = 'random-posts';
    public const LAST_VIDEOS = 'last-videos';
    public const ERROR_RANDOM_POSTS = 'error-random-posts';
    public const HOME_POPULAR_POSTS = 'home-random-posts';
    public const POSTS_SEARCH = 'post-search';
    public const TOP_LAST_MONTH = 'top-last-month';
    public const LATEST_POSTS = 'latest-posts';
}
