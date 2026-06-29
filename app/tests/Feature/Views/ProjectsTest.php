<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testGuestCanVisitPage(): void
    {
        $this->get(route('projects.index'))->assertOk()->assertViewIs('projects.index');
    }

    public function testAdminCanVisitPage(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user, 'admin')
            ->get(route('projects.index'))
            ->assertOk()
            ->assertViewIs('projects.index');
    }
}
