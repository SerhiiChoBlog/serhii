<?php

namespace App\Enums;

enum BadgeName: string
{
    case VERIFIED = 'verified';
    case COMMENTATOR = 'commentator';
    case LIKEABLE = 'likeable';

    /**
     * @return array<int, self>
     */
    public static function all(): array
    {
        return [
            self::VERIFIED,
            self::COMMENTATOR,
            self::LIKEABLE,
        ];
    }
}
