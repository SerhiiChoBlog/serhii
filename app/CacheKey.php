<?php

declare(strict_types=1);

namespace App;

abstract class CacheKey
{
    public const PROJECTS = 'projects';
    public const LAST_POSTS = 'last-posts';
    public const ERROR_RANDOM_POSTS = 'error-random-posts';
    public const HOME_RANDOM_POSTS = 'home-random-posts';
    public const HOME_POPULAR_VIDEOS = 'home-popular-videos';
    public const FETCHED_YOUTUBE_VIDEOS = 'fetched-youtube-videos';
}
