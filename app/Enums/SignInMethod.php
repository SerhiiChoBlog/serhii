<?php

namespace App\Enums;

enum SignInMethod: string
{
    case EMAIL = 'email';
    case GOOGLE = 'google';
    case APPLE = 'apple';
}
