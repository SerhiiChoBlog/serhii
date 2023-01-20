<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\Role;
use App\Models\User;
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
        $user = User::factory()->create();
        $role = Role::factory()->create(['name' => 'admin']);

        $user->roles()->attach([$role->id]);

        $this->actingAs($user, 'web')
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
        $user = User::factory()->make();

        $this->actingAs($user, 'user')
             ->post(route('login'))
             ->assertRedirect('/user/profile');
    }
}
