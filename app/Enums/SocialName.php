<?php

declare(strict_types=1);

namespace App\Enums;

enum SocialName: string
{
    case X = 'x';
    case LINKEDIN = 'linkedin';
    case REDDIT = 'reddit';
    case TELEGRAM = 'telegram';
    case FACEBOOK = 'facebook';
    case CLIPBOARD = 'clipboard';

    /**
     * @return SocialName[]
     */
    public static function all(): array
    {
        return [
            self::X,
            self::LINKEDIN,
            self::REDDIT,
            self::TELEGRAM,
            self::FACEBOOK,
            self::CLIPBOARD,
        ];
    }
}
