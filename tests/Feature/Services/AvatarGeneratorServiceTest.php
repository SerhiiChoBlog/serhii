<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use App\Services\AvatarGeneratorService;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AvatarGeneratorServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function testServiceSavesGlavatarImageIfExist(): void
    {
        $service = new AvatarGeneratorService('1990serzhil@gmail.com');
        $image_name = $service->handle();

        Storage::disk('public')->assertExists("avatars/{$image_name}");

        $this->assertStringContainsString('.jpg', $image_name);
    }

    public function testServiceSavesMultiavatarImage(): void
    {
        $service = new AvatarGeneratorService('ai1dsfj8lakfj9slkf0flk@ijsalkjdfkl.com');
        $image_name = $service->handle();

        Storage::disk('public')->assertExists("avatars/{$image_name}");

        $this->assertStringContainsString('.svg', $image_name);
    }
}
