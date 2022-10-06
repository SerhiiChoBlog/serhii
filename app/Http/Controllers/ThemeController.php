<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;

class ThemeController extends Controller
{
    private const DARK_THEME = 'dark';
    private const LIGHT_THEME = 'light';
    private const FIVE_MONTHS_IN_SECONDS = 13_149_000;

    public function __invoke(): void
    {
        $theme = Cookie::get('theme');

        !$theme || $theme === self::LIGHT_THEME
            ? Cookie::queue('theme', self::DARK_THEME, self::FIVE_MONTHS_IN_SECONDS)
            : Cookie::queue('theme', self::LIGHT_THEME, self::FIVE_MONTHS_IN_SECONDS);
    }
}
