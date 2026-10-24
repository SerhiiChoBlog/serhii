<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const INDEX_URI = '/admin/ajax/users';
    private const SHOW_URI = '/admin/ajax/users/';

    public function testIndexReturnsUserEmail(): void
    {
        $admin = $this->createAdmin();
        $user = User::factory()->create();

        $this->actingAs($admin, 'admin')
            ->getJson(self::INDEX_URI)
            ->assertOk()
            ->assertJsonFragment(['email' => $user->email]);
    }

    public function testShowReturnsUserEmail(): void
    {
        $admin = $this->createAdmin();
        $user = User::factory()->create();

        $this->actingAs($admin, 'admin')
            ->getJson(self::SHOW_URI . $user->slug)
            ->assertOk()
            ->assertJsonFragment(['email' => $user->email]);
    }
}
