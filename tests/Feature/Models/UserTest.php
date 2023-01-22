<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Enums\UserRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use LazilyRefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_be_created(): void
    {
        $this->assertDatabaseHas('users', [
            'name' => $this->user->name,
            'email' => $this->user->email,
        ]);
    }

    public function test_user_has_roles_associated(): void
    {
        /** @var Role $role */
        $role = Role::factory()->create(['name' => UserRole::ADMIN]);

        $this->user->roles()->attach([$role->id]);

        $this->assertCount(1, $this->user->roles);
    }

    public function test_method_returns_true_if_user_has_admin_role(): void
    {
        /** @var Role $role */
        $role = Role::factory()->create(['name' => 'admin']);

        $this->user->roles()->attach([$role->id]);

        $this->assertTrue($this->user->hasRole(UserRole::ADMIN));
    }

    public function test_method_returns_false_if_user_doesnt_have_admin_role(): void
    {
        $this->assertFalse($this->user->hasRole(UserRole::ADMIN));
    }
}
