<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
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
}
