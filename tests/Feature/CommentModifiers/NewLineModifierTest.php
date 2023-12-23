<?php

declare(strict_types=1);

namespace Tests\Feature\CommentModifiers;

use App\CommentModifiers\NewLineModifier;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class NewLineModifierTest extends TestCase
{
    use LazilyRefreshDatabase;

    #[DataProvider('providerForTestReplacesNewLinesWithBrTags')]
    public function testNewLinesWithBrTags(string $input, string $expect): void
    {
        $modifier = new NewLineModifier($input);
        $this->assertSame($expect, $modifier->modify());
    }

    public static function providerForTestReplacesNewLinesWithBrTags(): array
    {
        return [
            [
                <<<COMMENT
                This is my comment!
                This is a new line!
                COMMENT,
                'This is my comment!<br>This is a new line!',
            ],
            [
                <<<COMMENT
                This is my comment!
                This is a new line!
                This is another new line!
                COMMENT,
                'This is my comment!<br>This is a new line!<br>This is another new line!',
            ],
            [
                <<<COMMENT
                This is my comment!
                This is a new line!
                This is another new line!
                This is a third new line!
                COMMENT,
                'This is my comment!<br>This is a new line!<br>This is another new line!<br>This is a third new line!',
            ],
            ['13', '13'],
            [
                <<<COMMENT
                1
                3
                COMMENT,
                '1<br>3',
            ],
            [
                <<<COMMENT
                1

                3
                COMMENT,
                '1<br><br>3',
            ],
            [
                <<<COMMENT
                1


                3
                COMMENT,
                '1<br><br>3',
            ],
            [
                <<<COMMENT
                1





                3
                COMMENT,
                '1<br><br>3',
            ],
        ];
    }
}
