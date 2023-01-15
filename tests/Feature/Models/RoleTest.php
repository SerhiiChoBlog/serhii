<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_role_can_be_created(): void
    {
        $role = 'writer';
        Role::factory()->create(['name' => $role]);
        $this->assertDatabaseHas('roles', ['name' => $role]);
    }

    public function test_role_has_users_associated(): void
    {
        /** @var Role $role */
        $role = Role::factory()->create(['name' => 'admin']);

        /** @var User $user */
        $user = User::factory()->create();

        $role->users()->attach([$user->id]);

        $this->assertCount(1, $role->users);
    }
}
