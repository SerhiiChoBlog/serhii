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

        $this->actingAs($admin, 'admin')
            ->get(route('login'))
            ->assertRedirect();
    }

    public function test_user_cannot_visit_page_if_authenticated(): void
    {
        /** @var User $user */
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

    public function test_user_cannot_login_with_invalid_password(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $form_data = [
            'email' => $user->email,
            'password' => 'invalid-password',
        ];

        $this->post(route('login'), $form_data)
            ->assertSessionHasErrors();
    }

    public function test_user_cannot_login_with_invalid_email(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $form_data = [
            'email' => 'xx' . $user->email,
            'password' => 'password',
        ];

        $this->post(route('login'), $form_data)
             ->assertSessionHasErrors();
    }

    public function test_remember_me_token_is_set(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $form_data = [
            'email' => $user->email,
            'password' => 'password',
            'remember' => 'on',
        ];

        $this->post(route('login'), $form_data);

        $this->assertNotNull($user->fresh()->remember_token);
    }

    public function test_remember_me_token_is_not_set(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $form_data = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $this->post(route('login'), $form_data);

        $this->assertNull($user->fresh()->remember_token);
    }
}
