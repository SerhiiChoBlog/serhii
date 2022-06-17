<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @test */
    public function guest_can_visit_home_page(): void
    {
        $this->get('/')->assertOk()->assertViewIs('home');
    }

    /** @test */
    public function admin_can_visit_home_page(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user)
            ->get('/')
            ->assertOk()
            ->assertViewIs('home');
    }
}
