<?php

declare(strict_types=1);

namespace App\Utils;

final class ImageExtension
{
    /** @var array<string, string> */
    private const EXTENSIONS = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
        'image/bmp' => 'bmp',
        'image/svg+xml' => 'svg',
    ];

    public static function fromMimeType(string|null $mime_type): string
    {
        if ($mime_type === null) {
            return 'jpg';
        }

        return self::EXTENSIONS[$mime_type] ?? 'jpg';
    }
}
