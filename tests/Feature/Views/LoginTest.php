<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_visit_page(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertViewIs('auth.login');
    }

    /** @test */
    public function admin_cant_visit_page_if_authenticated(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user)
            ->get(route('login'))
            ->assertRedirect();
    }
}
