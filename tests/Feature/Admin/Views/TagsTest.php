<?php

declare(strict_types=1);

namespace Tests\Feature\Admin\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class TagsTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @test */
    public function guest_cant_visit_page(): void
    {
        $this->get(route('admin.tags.index'))->assertRedirect(route('login'));
    }

    /** @test */
    public function admin_can_visit_page(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user)
            ->get(route('admin.tags.index'))
            ->assertOk()
            ->assertViewIs('admin.tags.index');
    }
}
