<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guest_can_visit_page(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertViewIs('auth.register');
    }

    public function test_admin_cannot_visit_page_if_authenticated(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get(route('register'))
            ->assertRedirect(RouteServiceProvider::ADMIN_HOME);
    }

    public function test_user_cannot_visit_page_if_authenticated(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user, 'user')
            ->get(route('register'))
            ->assertRedirect(RouteServiceProvider::USER_HOME);
    }

    public function test_user_can_register_and_see_profile_page(): void
    {
        $form_data = [
            'name' => 'Anna Korotchaeva',
            'email' => 'anna.korotchaeva@protonmail.com',
            'password' => 'anna-korotchaeva-123',
        ];

        $this->post(route('register'), $form_data)
            ->assertRedirect(RouteServiceProvider::USER_HOME);

        $this->assertDatabaseHas('users', [
            'name' => $form_data['name'],
            'email' => $form_data['email'],
        ]);
    }

    public function test_password_is_hashed_correctly(): void
    {
        $form_data = [
            'name' => 'Anna Beauty',
            'email' => 'anna.beauty@mail.com',
            'password' => 'anna-beauty-password',
        ];

        $this->post(route('register'), $form_data);

        $pass = User::query()->first()?->password ?? '';

        $password_matches = Hash::check($form_data['password'], $pass);

        $this->assertTrue($password_matches);
    }
}
