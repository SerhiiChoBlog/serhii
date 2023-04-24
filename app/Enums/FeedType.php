<?php

declare(strict_types=1);

namespace App\Enums;

enum FeedType: string
{
    case COMMENT = 'comment';
    case LIKE = 'like';

    /**
     * @return array<int, FeedType>
     */
    public static function all(): array
    {
        return [
            self::COMMENT,
            self::LIKE,
        ];
    }
}
