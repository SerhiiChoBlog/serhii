<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Role;
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
}
