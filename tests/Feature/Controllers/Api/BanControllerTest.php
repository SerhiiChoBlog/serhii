<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api;

use App\Enums\UserRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class BanControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const BAN_URI = '/admin/ajax/bans/ban';
    private const UNBAN_URI = '/admin/ajax/bans/unban';

    public function test_admin_can_ban_user(): void
    {
        $user = User::factory()->create();
        $admin = User::factory()->create();

        $role = Role::factory()->create(['name' => UserRole::ADMIN]);
        $admin->roles()->attach($role->id);

        $params = [
            'user_id' => $user->id,
            'comment' => 'This is my comment',
        ];

        $this->actingAs($admin, 'admin')
            ->post(self::BAN_URI, $params)
            ->assertOk();

        $this->assertDatabaseHas('bans', $params);
    }

    public function test_user_cannot_ban_user(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $params = [
            'user_id' => $user->id,
            'comment' => 'This is my comment',
        ];

        $this->actingAs($user2, 'user')
            ->post(self::BAN_URI, $params)
            ->assertStatus(302);

        $this->assertDatabaseEMpty('bans');
    }


    public function test_guest_cannot_ban_user(): void
    {
        $user = User::factory()->create();

        $params = [
            'user_id' => $user->id,
            'comment' => 'This is my comment',
        ];

        $this->post(self::BAN_URI, $params)
            ->assertStatus(302);

        $this->assertDatabaseEMpty('bans');
    }
}
