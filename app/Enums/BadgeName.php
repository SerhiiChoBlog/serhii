<?php

namespace App\Enums;

enum BadgeName: string
{
    case VERIFIED = 'verified';
    case COMMENTATOR = 'commentator';
    case LIKEABLE = 'likeable';
}
