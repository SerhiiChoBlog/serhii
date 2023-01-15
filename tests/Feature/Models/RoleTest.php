<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Enums\UserRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_role_can_be_created(): void
    {
        Role::factory()->create(['name' => UserRole::ADMIN]);
        $this->assertDatabaseHas('roles', ['name' => UserRole::ADMIN]);
    }

    public function test_role_has_users_associated(): void
    {
        /** @var Role $role */
        $role = Role::factory()->create(['name' => UserRole::ADMIN]);

        /** @var User $user */
        $user = User::factory()->create();

        $role->users()->attach([$user->id]);

        $this->assertCount(1, $role->users);
    }
}
