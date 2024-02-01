<?php

declare(strict_types=1);

namespace Tests\Feature\CommentModifiers;

use App\CommentModifiers\ReplaceUrlsModifier;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ReplaceUrlsModifierTest extends TestCase
{
    use LazilyRefreshDatabase;

    #[DataProvider('providerForTestReplacesUrlsWithHtmlLinks')]
    public function testReplacesUrlsWithHtmlLinks(string $input, string $expect): void
    {
        $modifier = new ReplaceUrlsModifier($input);
        $this->assertSame($expect, $modifier->modify());
    }

    public static function providerForTestReplacesUrlsWithHtmlLinks(): array
    {
        return [
            [
                'This is a comment with a link https://example.com',
                'This is a comment with a link <a href="https://example.com" target="_blank">https://example.com</a>',
            ],
            [
                'This is a comment with a link http://example.com',
                'This is a comment with a link <a href="http://example.com" target="_blank">http://example.com</a>',
            ],
            [
                'This is a comment with a link https://example.com and another link http://example.com',
                'This is a comment with a link <a href="https://example.com" target="_blank">https://example.com</a> and another link <a href="http://example.com" target="_blank">http://example.com</a>',
            ],
            [
                'This is a comment with a link https://example.com and another link http://example.com and another link https://example.com',
                'This is a comment with a link <a href="https://example.com" target="_blank">https://example.com</a> and another link <a href="http://example.com" target="_blank">http://example.com</a> and another link <a href="https://example.com" target="_blank">https://example.com</a>',
            ],
            [
                'This is a comment with a link https://example.com and another link http://example.com and another link https://example.com and another link http://example.com',
                'This is a comment with a link <a href="https://example.com" target="_blank">https://example.com</a> and another link <a href="http://example.com" target="_blank">http://example.com</a> and another link <a href="https://example.com" target="_blank">https://example.com</a> and another link <a href="http://example.com" target="_blank">http://example.com</a>',
            ],
            [
                'Some http://example.com text https://example.com with http://example.com links https://example.com',
                'Some <a href="http://example.com" target="_blank">http://example.com</a> text <a href="https://example.com" target="_blank">https://example.com</a> with <a href="http://example.com" target="_blank">http://example.com</a> links <a href="https://example.com" target="_blank">https://example.com</a>',
            ],
            [
                'https://serhii.io/about-me',
                '<a href="https://serhii.io/about-me" target="_blank">https://serhii.io/about-me</a>',
            ],
            [
                'https://serhii.io/about-me.',
                '<a href="https://serhii.io/about-me" target="_blank">https://serhii.io/about-me</a>.',
            ],
            [
                'Link: https://serhii.io/about-me. Thanks!',
                'Link: <a href="https://serhii.io/about-me" target="_blank">https://serhii.io/about-me</a>. Thanks!',
            ],
            [
                'Link: https://serhii.io.',
                'Link: <a href="https://serhii.io" target="_blank">https://serhii.io</a>.',
            ],
            [
                'Link: https://serhii.io',
                'Link: <a href="https://serhii.io" target="_blank">https://serhii.io</a>',
            ],
        ];
    }
}
