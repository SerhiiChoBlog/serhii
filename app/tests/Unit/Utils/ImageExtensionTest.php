<?php

declare(strict_types=1);

namespace Tests\Unit\Utils;

use App\Utils\ImageExtension;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ImageExtensionTest extends TestCase
{
    #[DataProvider('providerForImageMimeTypes')]
    public function testItReturnsExtensionForImageMimeType(string $mime_type, string $expected): void
    {
        $this->assertSame($expected, ImageExtension::fromMimeType($mime_type));
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function providerForImageMimeTypes(): array
    {
        return [
            'jpeg' => ['image/jpeg', 'jpg'],
            'png' => ['image/png', 'png'],
            'gif' => ['image/gif', 'gif'],
            'webp' => ['image/webp', 'webp'],
            'bmp' => ['image/bmp', 'bmp'],
            'svg' => ['image/svg+xml', 'svg'],
        ];
    }

    #[DataProvider('providerForNonImageMimeTypes')]
    public function testItReturnsJpgForNonImageMimeType(string|null $mime_type): void
    {
        $this->assertSame('jpg', ImageExtension::fromMimeType($mime_type));
    }

    /**
     * @return array<string, array{string|null}>
     */
    public static function providerForNonImageMimeTypes(): array
    {
        return [
            'php' => ['application/x-php'],
            'text' => ['text/plain'],
            'html' => ['text/html'],
            'octet stream' => ['application/octet-stream'],
            'unknown' => [null],
        ];
    }
}
