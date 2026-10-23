<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Alignment;
use Intervention\Image\Laravel\Facades\Image;

readonly class ImageProcessor
{
    /**
     * @param array<string, list<int>> $sizes
     */
    public function __construct(private UploadedFile|null $photo, private array $sizes)
    {
    }

    /**
     * @return null|array{
     *     xs: string,
     *     sm: string,
     *     lg: string,
     * }
     */
    public function save(string $post_name, string $dir_name): array|null
    {
        if ($this->photo === null) {
            return null;
        }

        $path = storage_path("app/public/{$dir_name}");
        $mimeType = $this->photo->getMimeType();
        $ext = ImageExtension::fromMimeType($mimeType);
        $name = Str::slug($post_name) . ".{$ext}";

        foreach ($this->sizes as $size => $d) {
            Image::decode($this->photo)
                ->cover($d[0], $d[1], Alignment::TOP)
                ->save("{$path}/{$size}/{$name}");
        }

        return [
            'xs' => "storage/{$dir_name}/xs/{$name}",
            'sm' => "storage/{$dir_name}/sm/{$name}",
            'lg' => "storage/{$dir_name}/lg/{$name}",
        ];
    }
}
