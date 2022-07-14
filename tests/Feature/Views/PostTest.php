<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    private Post $post;

    public function setUp(): void
    {
        parent::setUp();
        $this->post = Post::factory()->create();
    }

    /** @test */
    public function guest_can_visit_page(): void
    {
        $this->get(route('posts.show', $this->post))
            ->assertOk()
            ->assertViewIs('posts.show');
    }

    /** @test */
    public function admin_can_visit_page(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user)
            ->get(route('posts.show', $this->post))
            ->assertOk()
            ->assertViewIs('posts.show');
    }
}
