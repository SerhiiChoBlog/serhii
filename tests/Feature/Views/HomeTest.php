<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guest_can_visit_page(): void
    {
        $this->get(route('home'))->assertOk()->assertViewIs('home');
    }

    public function test_admin_can_visit_page(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user, 'admin')
            ->get(route('home'))
            ->assertOk()
            ->assertViewIs('home');
    }
}
