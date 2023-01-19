<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @test */
    public function guest_can_visit_page(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertViewIs('auth.register');
    }

    /** @test */
    public function admin_cannot_visit_page_if_authenticated(): void
    {
        $user = User::factory()->create();
        $role = Role::factory()->create(['name' => 'admin']);

        $user->roles()->attach([$role->id]);

        $this->actingAs($user, 'web')
            ->get(route('register'))
            ->assertRedirect();
    }

    /** @test */
    public function user_cannot_visit_page_if_authenticated(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user, 'user')
             ->get(route('register'))
             ->assertRedirect();
    }
}
