<?php

namespace App\Enums;

enum SocialName: string
{
    case TWITTER = 'twitter';
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
            self::TWITTER,
            self::LINKEDIN,
            self::REDDIT,
            self::TELEGRAM,
            self::FACEBOOK,
            self::CLIPBOARD,
        ];
    }
}
