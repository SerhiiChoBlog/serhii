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
        if (is_null($photo)) {
            return null;
        }

        $path_sm = storage_path('app/public/posts/sm');
        $path_lg = storage_path('app/public/posts/lg');
        $image_name = Str::slug($post_name) . '.' . $photo->getClientOriginalExtension();

        Image::make($photo)
            ->fit(550, 300, fn($constraint) => $constraint->upsize())
            ->save("$path_sm/$image_name");

        Image::make($photo)
            ->fit(1100, 600, fn($constraint) => $constraint->upsize())
            ->save("$path_lg/$image_name");

        return [
            'sm' => "storage/posts/sm/$image_name",
            'lg' => "storage/posts/lg/$image_name",
        ];
    }
}
