<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;

class ThemeController extends Controller
{
    private const FIVE_MONTHS_IN_SECONDS = 13_149_000;

    public function __invoke(string $to): void
    {
        Cookie::queue('theme', $to, self::FIVE_MONTHS_IN_SECONDS);
    }
}
