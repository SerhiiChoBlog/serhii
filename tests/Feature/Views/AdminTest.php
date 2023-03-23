<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testAdminCanVisitAdminDashboard(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get(RouteServiceProvider::ADMIN_HOME)
            ->assertOk();
    }

    public function testUserCannotVisitAdminDashboard(): void
    {
        $user = $this->createUser();

        $this->actingAs($user, 'user')
            ->get(RouteServiceProvider::ADMIN_HOME)
            ->assertRedirectToRoute('home');
    }

    public function testGuestCannotVisitAdminDashboard(): void
    {
        $this->get(RouteServiceProvider::ADMIN_HOME)->assertRedirectToRoute('home');
    }
}
