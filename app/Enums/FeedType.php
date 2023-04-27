<?php

declare(strict_types=1);

namespace App\Enums;

enum FeedType: string
{
    case COMMENT = 'comment';
    case POST_LIKE = 'post-like';
    case BADGE = 'badge';
    case COMMENT_LIKE = 'comment-like';

    /**
     * @return array<int, FeedType>
     */
    public static function all(): array
    {
        return [
            self::COMMENT,
            self::POST_LIKE,
            self::BADGE,
            self::COMMENT_LIKE,
        ];
    }
}
