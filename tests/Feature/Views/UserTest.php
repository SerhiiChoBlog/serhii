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

    public function test_user_can_visit_user_profile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'user')
            ->get(RouteServiceProvider::USER_HOME)
            ->assertOk();
    }

    public function test_admin_cannot_visit_user_profile(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get(RouteServiceProvider::USER_HOME)
            ->assertRedirectToRoute('login');
    }

    public function test_guest_cannot_visit_user_profile(): void
    {
        $this->get(RouteServiceProvider::USER_HOME)->assertRedirectToRoute('login');
    }
}
