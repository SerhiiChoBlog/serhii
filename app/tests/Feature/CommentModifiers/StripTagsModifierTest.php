<?php

declare(strict_types=1);

namespace Tests\Feature\CommentModifiers;

use App\CommentModifiers\StripTagsModifier;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class StripTagsModifierTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testModifierEscapesAllHtmlTagsExceptAnchorTag(): void
    {
        $comment = 'You <b>need</b> to read <script>alert("Hello!");</script> article! This is <a href="https://google.com">link</a> to google!';
        $expect = 'You need to read alert("Hello!"); article! This is <a href="https://google.com">link</a> to google!';

        $modifier = new StripTagsModifier($comment);

        $this->assertSame($expect, $modifier->modify());
    }
}
