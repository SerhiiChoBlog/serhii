<?php

declare(strict_types=1);

namespace App\Utils;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

readonly class ProfilePhotoProcessor
{
    public function __construct(private UploadedFile $photo, private User $user)
    {
    }

    public function save(): string
    {
        $path = storage_path("app/public/avatars");
        $name = sprintf('%s-%d.%s', $this->user->slug, time(), $this->photo->getClientOriginalExtension());

        Image::make($this->photo)
            ->fit(400, 400, fn ($c) => $c->upsize())
            ->save("{$path}/{$name}");

        $this->deleteOldPhoto();

        return $name;
    }

    private function deleteOldPhoto(): void
    {
        if ($this->user->avatar === User::DEFAULT_IMAGE_NAME) {
            return;
        }

        $path = storage_path("app/public/avatars/{$this->user->avatar}");

        if (file_exists($path)) {
            unlink($path);
        }
    }
}
