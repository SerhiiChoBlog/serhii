<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_user_can_be_created(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function test_user_has_roles_associated(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Role $role */
        $role = Role::factory()->create(['name' => 'admin']);

        $user->roles()->attach([$role->id]);

        $this->assertCount(1, $user->roles);
    }
}
