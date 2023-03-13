<?php

declare(strict_types=1);

namespace Tests\Feature\Util;

use App\Utils\RomanNumber;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class RomanNumberTest extends TestCase
{
    use LazilyRefreshDatabase;

    /**
     * @dataProvider dataProviderForTestRomanNumberUtilityConvertsToRomanNumber
     */
    public function testRomanNumberUtilityConvertsToRomanNumber(int $num, string $expect): void
    {
        $this->assertEquals($expect, RomanNumber::convert($num));
    }

    public static function dataProviderForTestRomanNumberUtilityConvertsToRomanNumber(): array
    {
        return [
            [1, 'I'],
            [2, 'II'],
            [3, 'III'],
            [4, 'IV'],
            [5, 'V'],
            [6, 'VI'],
            [7, 'VII'],
            [8, 'VIII'],
            [9, 'IX'],
            [10, 'X'],
            [11, 'XI'],
            [12, 'XII'],
            [13, 'XIII'],
            [14, 'XIV'],
            [15, 'XV'],
            [16, 'XVI'],
            [17, 'XVII'],
            [18, 'XVIII'],
            [19, 'XIX'],
            [20, 'XX'],
            [21, 'XXI'],
            [22, 'XXII'],
            [23, 'XXIII'],
            [24, 'XXIV'],
            [25, 'XXV'],
            [26, 'XXVI'],
            [27, 'XXVII'],
            [28, 'XXVIII'],
            [29, 'XXIX'],
            [30, 'XXX'],
            [31, 'XXXI'],
            [32, 'XXXII'],
            [33, 'XXXIII'],
            [34, 'XXXIV'],
            [35, 'XXXV'],
            [36, 'XXXVI'],
            [37, 'XXXVII'],
            [38, 'XXXVIII'],
            [39, 'XXXIX'],
            [40, 'XL'],
            [100, 'C'],
            [500, 'D'],
            [1000, 'M'],
            [1001, 'MI'],
            [1002, 'MII'],
            [1003, 'MIII'],
            [1004, 'MIV'],
            [1005, 'MV'],
            [1006, 'MVI'],
            [1007, 'MVII'],
            [1008, 'MVIII'],
            [1009, 'MIX'],
            [1010, 'MX'],
            [1011, 'MXI'],
            [1012, 'MXII'],
            [1013, 'MXIII'],
            [1014, 'MXIV'],
            [1015, 'MXV'],
            [1016, 'MXVI'],
            [1017, 'MXVII'],
            [1018, 'MXVIII'],
            [1019, 'MXIX'],
            [1020, 'MXX'],
            [1021, 'MXXI'],
            [1022, 'MXXII'],
            [1023, 'MXXIII'],
            [1024, 'MXXIV'],
            [1025, 'MXXV'],
            [1026, 'MXXVI'],
            [1027, 'MXXVII'],
            [1028, 'MXXVIII'],
            [1029, 'MXXIX'],
            [1030, 'MXXX'],
            [1031, 'MXXXI'],
            [1032, 'MXXXII'],
            [1033, 'MXXXIII'],
            [1034, 'MXXXIV'],
            [1035, 'MXXXV'],
            [1036, 'MXXXVI'],
            [1037, 'MXXXVII'],
            [1038, 'MXXXVIII'],
            [1039, 'MXXXIX'],
            [1040, 'MXL'],
            [1041, 'MXLI'],
            [1042, 'MXLII'],
            [1043, 'MXLIII'],
            [1044, 'MXLIV'],
            [1045, 'MXLV'],
            [1046, 'MXLVI'],
            [1047, 'MXLVII'],
            [1048, 'MXLVIII'],
            [1049, 'MXLIX'],
            [1050, 'ML'],
        ];
    }
}
