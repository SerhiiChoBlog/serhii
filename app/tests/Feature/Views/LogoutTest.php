<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testUserCanLogout(): void
    {
        $user = $this->createUser()->refresh();

        $this->actingAs($user, 'user')
            ->post(route('logout'))
            ->assertRedirect('/');

        $this->assertGuest('user');
        $this->assertGuest('admin');
    }

    public function testAdminCanLogout(): void
    {
        $admin = $this->createAdmin()->refresh();

        $this->actingAs($admin, 'admin')
            ->post(route('logout'))
            ->assertRedirect('/');

        $this->assertGuest('admin');
        $this->assertGuest('user');
    }
}
