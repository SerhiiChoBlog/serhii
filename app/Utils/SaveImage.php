<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait SaveImage
{
    public function savePhotoIfExist(?UploadedFile $photo, string $post_name): ?array
    {
        if ($photo === null) {
            return null;
        }

        $path = storage_path('app/public/posts');
        $ext = $photo->getClientOriginalExtension();
        $name = Str::slug($post_name) . ".{$ext}";

        foreach ($this->getSizes() as $size => $d) {
            Image::make($photo)
                ->fit($d[0], $d[1], fn ($c) => $c->upsize())
                ->save("{$path}/{$size}/{$name}");
        }

        return [
            'xs' => "storage/posts/xs/{$name}",
            'sm' => "storage/posts/sm/{$name}",
            'lg' => "storage/posts/lg/{$name}",
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
