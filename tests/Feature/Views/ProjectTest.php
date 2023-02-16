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

    public function testGuestCanVisitPage(): void
    {
        $this->get(route('projects.show', $this->project))
            ->assertOk()
            ->assertViewIs('projects.show');
    }

    public function testAdminCanVisitPage(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user, 'admin')
            ->get(route('projects.show', $this->project))
            ->assertOk()
            ->assertViewIs('projects.show');
    }
}
