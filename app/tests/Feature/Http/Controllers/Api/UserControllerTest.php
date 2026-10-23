<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testUserWithLongSlugCanUploadPhoto(): void
    {
        Storage::fake('public');

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        /** @var User $user */
        $user = User::factory()->create([
            'slug' => 'oleksandr-kovalenko-shevchuk',
            'avatar' => 'old-avatar.jpg',
        ]);

        $disk->put('avatars/old-avatar.jpg', 'old-avatar');

        $this->actingAs($user, 'user')
            ->postJson('/api/users/upload-photo', [
                'photo' => UploadedFile::fake()->image('photo.jpg')->size(10),
            ])
            ->assertOk();

        $user->refresh();

        $this->assertStringNotContainsString($user->slug, $user->avatar);
        $this->assertStringEndsWith('.jpg', $user->avatar);

        $disk->assertExists("avatars/{$user->avatar}");
        $disk->assertMissing('avatars/old-avatar.jpg');
    }

    public function testOldAvatarIsKeptWhenUpdatingUserFails(): void
    {
        Storage::fake('public');
        $this->withoutExceptionHandling();

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        /** @var User $user */
        $user = User::factory()->create(['avatar' => 'old-avatar.jpg']);

        $disk->put('avatars/old-avatar.jpg', 'old-avatar');

        User::updating(function (): void {
            throw new RuntimeException('Database failure');
        });

        try {
            $this->actingAs($user, 'user')
                ->postJson('/api/users/upload-photo', [
                    'photo' => UploadedFile::fake()->image('photo.jpg')->size(10),
                ]);

            $this->fail('Expected the user update to fail.');
        } catch (RuntimeException) {
            // Expected.
        }

        $disk->assertExists('avatars/old-avatar.jpg');
    }
}
