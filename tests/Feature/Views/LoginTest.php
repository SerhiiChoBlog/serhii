<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guest_can_visit_page(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertViewIs('auth.login');
    }

    public function test_admin_cannot_visit_page_if_authenticated(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'web')
            ->get(route('login'))
            ->assertRedirect();
    }

    public function test_user_cannot_visit_page_if_authenticated(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user, 'user')
             ->get(route('login'))
             ->assertRedirect();
    }

    public function test_user_can_login_and_see_profile_page(): void
    {
        $user = User::factory()->create();

        $form_data = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $this->post(route('login'), $form_data)
            ->assertRedirect(RouteServiceProvider::USER_HOME);
    }

    public function test_admin_can_login_and_see_dashboard_page(): void
    {
        $admin = $this->createAdmin();

        $form_data = [
            'email' => $admin->email,
            'password' => 'password',
        ];

        $this->post(route('login'), $form_data)
            ->assertRedirect(RouteServiceProvider::ADMIN_HOME);
    }
}
