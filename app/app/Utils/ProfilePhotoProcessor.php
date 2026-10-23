<?php

declare(strict_types=1);

namespace App\Utils;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Alignment;
use Intervention\Image\Laravel\Facades\Image;

readonly class ProfilePhotoProcessor
{
    public function __construct(private UploadedFile $photo)
    {
    }

    public function save(): string
    {
        $extension = ImageExtension::fromMimeType($this->photo->getMimeType());
        $disk = Storage::disk('public');

        do {
            $name = Str::random(20) . ".{$extension}";
        } while ($disk->exists("avatars/{$name}"));

        $disk->makeDirectory('avatars');

        Image::decode($this->photo)
            ->contain(400, 400, alignment: Alignment::CENTER)
            ->save($disk->path("avatars/{$name}"));

        return $name;
    }

    public function deletePhoto(string $name): void
    {
        if ($name === User::DEFAULT_IMAGE_NAME) {
            return;
        }

        Storage::disk('public')->delete("avatars/{$name}");
    }
}
