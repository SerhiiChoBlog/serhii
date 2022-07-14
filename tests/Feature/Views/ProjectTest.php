<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    private Project $project;

    public function setUp(): void
    {
        parent::setUp();
        $this->project = Project::factory()->create();
    }

    /** @test */
    public function guest_can_visit_page(): void
    {
        $this->get(route('projects.show', $this->project))
            ->assertOk()
            ->assertViewIs('projects.show');
    }

    /** @test */
    public function admin_can_visit_page(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user)
            ->get(route('projects.show', $this->project))
            ->assertOk()
            ->assertViewIs('projects.show');
    }
}
