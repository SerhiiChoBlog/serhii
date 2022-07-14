<?php

declare(strict_types=1);

namespace Tests\Feature\Admin\Views;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class EditPostTest extends TestCase
{
    use LazilyRefreshDatabase;

    private Post $post;

    public function setUp(): void
    {
        parent::setUp();
        $this->post = Post::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_page(): void
    {
        $this->get(route('admin.posts.edit', $this->post))->assertRedirect(route('login'));
    }

    /** @test */
    public function admin_can_visit_page(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user)
            ->get(route('admin.posts.edit', $this->post))
            ->assertOk()
            ->assertViewIs('admin.posts.edit');
    }
}
