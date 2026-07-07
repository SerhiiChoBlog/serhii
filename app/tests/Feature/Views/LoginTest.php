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

    public function testGuestCanVisitPage(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertViewIs('auth.login');
    }

    public function testAdminCannotVisitPageIfAuthenticated(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get(route('login'))
            ->assertRedirect('/');
    }

    public function testUserCannotVisitPageIfAuthenticated(): void
    {
        /** @var User $user */
        $user = User::factory()->make();

        $this->actingAs($user, 'user')
            ->get(route('login'))
            ->assertRedirect('/');
    }

    public function testUserCanLoginAndSeeProfilePage(): void
    {
        $user = $this->createUser();

        $form_data = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $this->post(route('login'), $form_data)
            ->assertRedirect(RouteServiceProvider::USER_HOME);
    }

    public function testAdminCanLoginAndSeeDashboardPage(): void
    {
        $admin = $this->createAdmin();

        $form_data = [
            'email' => $admin->email,
            'password' => 'password',
        ];

        $this->post(route('login'), $form_data)
            ->assertRedirect(RouteServiceProvider::ADMIN_HOME);
    }

    public function testUserCannotLoginWithInvalidPassword(): void
    {
        /** @var User $user */
        $user = $this->createUser();

        $form_data = [
            'email' => $user->email,
            'password' => 'invalid-password',
        ];

        $this->post(route('login'), $form_data)
            ->assertSessionHasErrors('email');
    }

    public function testUserCannotLoginWithInvalidEmail(): void
    {
        /** @var User $user */
        $user = $this->createUser();

        $form_data = [
            'email' => 'xx' . $user->email,
            'password' => 'password',
        ];

        $this->post(route('login'), $form_data)
            ->assertSessionHasErrors('email');
    }

    public function testRememberMeTokenIsSet(): void
    {
        /** @var User $user */
        $user = $this->createUser();

        $form_data = [
            'email' => $user->email,
            'password' => 'password',
            'remember' => 'on',
        ];

        $this->post(route('login'), $form_data);

        $this->assertNotNull($user->fresh()->remember_token);
    }

    public function testRememberMeTokenIsNotSet(): void
    {
        /** @var User $user */
        $user = $this->createUser();

        $form_data = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $this->post(route('login'), $form_data);

        $this->assertNull($user->fresh()->remember_token);
    }
}
