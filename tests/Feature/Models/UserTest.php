<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Enums\BadgeName;
use App\Enums\UserRole;
use App\Models\Badge;
use App\Models\Ban;
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
        $this->assertDatabaseCount('users', 1);
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

    public function test_has_relation_with_badges(): void
    {
        $badge = Badge::factory()->create();

        $this->user->badges()->attach([$badge->id]);

        $this->assertCount(1, $this->user->badges);
    }

    public function test_giveBadge_method_add_badge(): void
    {
        Badge::factory()->create(['name' => BadgeName::LIKEABLE]);

        $this->user->giveBadge(BadgeName::LIKEABLE);

        $badge = $this->user->badges()->first();

        $this->assertSame(BadgeName::LIKEABLE, $badge->name);
    }

    public function test_giveBadge_method_skips_the_operation_if_no_badge_found(): void
    {
        $this->user->giveBadge(BadgeName::LIKEABLE);
        $this->assertSame(0, $this->user->badges()->count());
    }

    public function test_user_has_relationship_with_ban(): void
    {
        $ban = Ban::factory()->create(['user_id' => $this->user->id]);
        $this->assertNotNull($this->user->ban);
    }
}
