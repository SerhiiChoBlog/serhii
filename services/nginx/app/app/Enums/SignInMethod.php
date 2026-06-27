<?php

declare(strict_types=1);

namespace App\Enums;

enum SignInMethod: string
{
    case EMAIL = 'email';
    case GOOGLE = 'google';
    case GITHUB = 'github';
}
