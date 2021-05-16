<?php

declare(strict_types=1);

namespace App;

abstract class Ttl
{
    public const MINUTE = 60;
    public const HOUR = self::MINUTE * 60;
    public const DAY = self::HOUR * 24;
}
