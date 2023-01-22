<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_admin_can_visit_admin_dashboard(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get(RouteServiceProvider::ADMIN_HOME)
            ->assertOk();
    }

    public function test_user_cannot_visit_admin_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'user')
            ->get(RouteServiceProvider::ADMIN_HOME)
            ->assertRedirectToRoute('login');
    }

    public function test_guest_cannot_visit_admin_dashboard(): void
    {
        $this->get(RouteServiceProvider::ADMIN_HOME)->assertRedirectToRoute('login');
    }
}
