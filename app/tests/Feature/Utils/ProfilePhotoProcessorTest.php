<?php

declare(strict_types=1);

namespace Tests\Feature\Utils;

use App\Utils\ProfilePhotoProcessor;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProfilePhotoProcessorTest extends TestCase
{
    public function testItRegeneratesNameWhenFileAlreadyExists(): void
    {
        Storage::fake('public');

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        $disk->put('avatars/taken.jpg', 'existing-avatar');

        // Stub next Str::random() to be these 2 values
        Str::createRandomStringsUsingSequence(['taken', 'free']);

        try {
            $processor = new ProfilePhotoProcessor(UploadedFile::fake()->image('photo.jpg'));
            $name = $processor->save();
        } finally {
            Str::createRandomStringsNormally();
        }

        $this->assertSame('free.jpg', $name);
        $this->assertSame('existing-avatar', $disk->get('avatars/taken.jpg'));

        $disk->assertExists('avatars/free.jpg');
    }
}
