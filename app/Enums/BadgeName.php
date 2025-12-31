<?php

declare(strict_types=1);

namespace App\Enums;

enum BadgeName: string
{
    case VERIFIED = 'verified';
    case COMMENTATOR = 'commentator';
    case LOVELY = 'lovely';

    /**
     * @return list<self>
     */
    public static function all(): array
    {
        return [
            self::VERIFIED,
            self::COMMENTATOR,
            self::LOVELY,
        ];
    }
}
