<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use App\AvatarGenerators\GlavatarAvatarGenerator;
use App\Services\GenerateAvatarService;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GenerateAvatarServiceTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function testServiceSavesGlavatarImageIfExist(): void
    {
        $url = GlavatarAvatarGenerator::URL . '*';

        Http::fake([$url => Http::response('some-binary-here')]);

        $user_slug = 'alexey-chopin';

        $service = new GenerateAvatarService('1990serzhil@gmail.com', $user_slug);
        $image_name = $service->handle();

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        $disk->assertExists("avatars/{$image_name}");

        $this->assertStringContainsString('.jpg', $image_name);
        $this->assertStringContainsString($user_slug, $image_name);
    }

    public function testServiceSavesMultiavatarImage(): void
    {
        $user_slug = 'anna-korotchaeva';

        $service = new GenerateAvatarService('ai1dsfj8lakfj9slkf0flk@ijsalkjdfkl.com', $user_slug);
        $image_name = $service->handle();

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        $disk->assertExists("avatars/{$image_name}");

        $this->assertStringContainsString('.svg', $image_name);
        $this->assertStringContainsString($user_slug, $image_name);
    }
}
