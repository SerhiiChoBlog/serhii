<?php

declare(strict_types=1);

namespace Tests\Feature\Admin\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @test */
    public function guest_cant_visit_page(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    /** @test */
    public function admin_can_visit_page(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertViewIs('admin.dashboard');
    }
}
