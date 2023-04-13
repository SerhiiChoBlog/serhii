<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api;

use App\Models\WpPagerUser;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class WpPagerUserControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const STORE_URI = '/api/wp-pager-user';

    public function testWpPagerUserCanBeCreated(): void
    {
        $response = $this->json('post', self::STORE_URI, [
            'host' => 'example.com',
            'is_active' => true,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('wp_pager_users', [
            'host' => 'example.com',
            'is_active' => true,
        ]);
    }

    public function testWeUpdateIsActiveFieldWhenCreatingUserThatExist(): void
    {
        $user = WpPagerUser::factory()->create();

        $response = $this->json('post', self::STORE_URI, [
            'host' => $user->host,
            'is_active' => false,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseCount('wp_pager_users', 1);

        $this->assertDatabaseHas('wp_pager_users', [
            'host' => $user->host,
            'is_active' => false,
        ]);
    }

    public function testSecondUserCanBeCreatedWithDifferentHostName(): void
    {
        $user = WpPagerUser::factory()->create();

        $response = $this->json('post', self::STORE_URI, [
            'host' => 'google.com',
            'is_active' => true,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseCount('wp_pager_users', 2);

        $this->assertDatabaseHas('wp_pager_users', [
            'host' => 'google.com',
            'is_active' => true,
        ]);
    }
}
