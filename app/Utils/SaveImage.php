<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait SaveImage
{
    /**
     * @return null|array{
     *     xs: string,
     *     sm: string,
     *     lg: string,
     * }
     */
    public function savePhotoIfExist(?UploadedFile $photo, string $post_name, string $dir_name): ?array
    {
        if ($photo === null) {
            return null;
        }

        $path = storage_path("app/public/{$dir_name}");
        $ext = $photo->getClientOriginalExtension();
        $name = Str::slug($post_name) . ".{$ext}";

        foreach ($this->getSizes() as $size => $d) {
            Image::make($photo)
                ->fit($d[0], $d[1], fn ($c) => $c->upsize())
                ->save("{$path}/{$size}/{$name}");
        }

        return [
            'xs' => "storage/{$dir_name}/xs/{$name}",
            'sm' => "storage/{$dir_name}/sm/{$name}",
            'lg' => "storage/{$dir_name}/lg/{$name}",
        ];
    }

    /**
     * @return array<string, array<int, int>>
     */
    private function getSizes(): array
    {
        return [
            'xs' => [100, 50],
            'sm' => [550, 275],
            'lg' => [1000, 500],
        ];
    }
}
