<?php

declare(strict_types=1);

namespace Tests\Feature\CommentModifiers;

use App\CommentModifiers\SanitizeHtmlModifier;
use Tests\TestCase;

class SanitizeHtmlModifierTest extends TestCase
{
    public function testModifierRemovesDangerousAttributesAndJavascriptLinks(): void
    {
        $comment = '<a href="javascript:alert(window.Auth.secret)" onmouseover="alert(1)" style="display:block;padding:200px">hi</a>';

        $modifier = new SanitizeHtmlModifier($comment);

        $result = $modifier->modify();

        $this->assertSame('<a>hi</a>', $result);
    }

    public function testModifierKeepsSafeHttpLinks(): void
    {
        $comment = '<a href="https://example.com" target="_blank">example</a>';

        $modifier = new SanitizeHtmlModifier($comment);

        $result = $modifier->modify();

        $this->assertStringContainsString('href="https://example.com"', $result);
        $this->assertStringContainsString('target="_blank"', $result);
        $this->assertStringContainsString('>example</a>', $result);
    }

    public function testModifierKeepsLineBreaks(): void
    {
        $modifier = new SanitizeHtmlModifier("first line<br>second line");

        $this->assertSame('first line<br />second line', $modifier->modify());
    }
}
