<?php

declare(strict_types=1);

namespace App\Services;

use App\AvatarGenerators\AvatarGenerator;
use App\AvatarGenerators\GlavatarAvatarGenerator;
use App\AvatarGenerators\MultiavatarAvatarGenerator;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

readonly class GenerateAvatarService
{
    public function __construct(private string $email, private string $slug)
    {
    }

    public function handle(): string
    {
        try {
            return $this->generateAndSaveAvatar();
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return User::DEFAULT_IMAGE_NAME;
        }
    }

    private function generateAndSaveAvatar(): string
    {
        $glavatar = $this->getImage(new GlavatarAvatarGenerator($this->email));

        if ($glavatar) {
            return $this->saveImage($glavatar, 'jpg');
        }

        $multiavatar = $this->getImage(new MultiavatarAvatarGenerator($this->email));

        if ($multiavatar) {
            return $this->saveImage($multiavatar, 'svg');
        }

        return User::DEFAULT_IMAGE_NAME;
    }

    private function getImage(AvatarGenerator $generator): string|null
    {
        return $generator->generate();
    }

    /**
     * @param string $image The image binary
     * @param 'jpg'|'svg' $ext The image extension
     *
     * @return string The name of the saved image
     */
    private function saveImage(string $image, string $ext): string
    {
        $name = "{$this->slug}.{$ext}";

        Storage::disk('public')->put("avatars/{$name}", $image);

        return $name;
    }
}
