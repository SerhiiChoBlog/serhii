<?php

declare(strict_types=1);

namespace App\Utils;

readonly class RomanNumber
{
    public static function convert(int $subject): string
    {
        $result = '';

        $roman_numerals = [
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1,
        ];

        foreach ($roman_numerals as $roman => $number) {
            $matches = (int) ($subject / $number);
            $result .= str_repeat($roman, $matches);
            $subject %= $number;
        }

        return $result;
    }
}
