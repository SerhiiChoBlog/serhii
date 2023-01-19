<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use LazilyRefreshDatabase;

    private Project $project;

    public function setUp(): void
    {
        parent::setUp();
        $this->project = Project::factory()->create();
    }

    public function test_guest_can_visit_page(): void
    {
        $this->get(route('projects.show', $this->project))
            ->assertOk()
            ->assertViewIs('projects.show');
    }

    public function test_admin_can_visit_page(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user)
            ->get(route('projects.show', $this->project))
            ->assertOk()
            ->assertViewIs('projects.show');
    }
}
