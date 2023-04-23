<?php

declare(strict_types=1);

namespace App\Enums;

enum FeedType: string
{
    case COMMENT = 'comment';
    case LIKE = 'like';
}
