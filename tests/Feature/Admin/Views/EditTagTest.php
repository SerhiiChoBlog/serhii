<?php

declare(strict_types=1);

namespace Tests\Feature\Admin\Views;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class EditTagTest extends TestCase
{
    use LazilyRefreshDatabase;

    private Tag $tag;

    public function setUp(): void
    {
        parent::setUp();
        $this->tag = Tag::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_page(): void
    {
        $this->get(route('admin.tags.edit', $this->tag))->assertRedirect(route('login'));
    }

    /** @test */
    public function admin_can_visit_page(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user)
            ->get(route('admin.tags.edit', $this->tag))
            ->assertOk()
            ->assertViewIs('admin.tags.edit');
    }
}
