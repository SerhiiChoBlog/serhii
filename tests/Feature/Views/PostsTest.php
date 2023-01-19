<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class PostsTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guest_can_visit_page(): void
    {
        $this->get(route('posts.index'))->assertOk()->assertViewIs('posts.index');
    }

    public function test_admin_can_visit_page(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user)
            ->get(route('posts.index'))
            ->assertOk()
            ->assertViewIs('posts.index');
    }

    public function test_blog_page_redirects_to_posts(): void
    {
        $this->get('/blog')->assertRedirect(route('posts.index'));
    }
}
