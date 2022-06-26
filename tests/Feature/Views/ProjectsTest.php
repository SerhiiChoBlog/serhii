<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @test */
    public function guest_can_visit_projects_page(): void
    {
        $this->get(route('projects.index'))->assertOk()->assertViewIs('projects.index');
    }

    /** @test */
    public function admin_can_visit_projects_page(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user)
            ->get(route('projects.index'))
            ->assertOk()
            ->assertViewIs('projects.index');
    }
}
