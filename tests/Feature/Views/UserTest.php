<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testUserCanVisitUserProfile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'user')
            ->get(RouteServiceProvider::USER_HOME)
            ->assertOk();
    }

    public function testAdminCannotVisitUserProfile(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get(RouteServiceProvider::USER_HOME)
            ->assertRedirectToRoute('login');
    }

    public function testGuestCannotVisitUserProfile(): void
    {
        $this->get(RouteServiceProvider::USER_HOME)->assertRedirectToRoute('login');
    }
}
