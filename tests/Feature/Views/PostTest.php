<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guest_can_visit_published_post_page(): void
    {
        $published_post = Post::factory()->published()->create();

        $this->get(route('posts.show', $published_post))
            ->assertOk()
            ->assertViewIs('posts.show');
    }

    public function test_admin_can_visit_page(): void
    {
        $published_post = Post::factory()->published()->create();
        $user = User::factory()->make();

        $this->actingAs($user)
            ->get(route('posts.show', $published_post))
            ->assertOk()
            ->assertViewIs('posts.show');
    }

    public function test_user_can_see_the_post_if_its_not_published(): void
    {
        $post = Post::factory()->create();
        $this->get(route('posts.show', $post))->assertSuccessful();
    }

    public function test_admin_can_see_the_post_if_its_not_published(): void
    {
        $user = User::factory()->make();
        $post = Post::factory()->create();

        $this->actingAs($user)
            ->get(route('posts.show', $post))
            ->assertOk();
    }

    public function test_post_page_has_post_title(): void
    {
        $post_title = 'This is some nice title for the post';
        $post = Post::factory()->published()->title($post_title)->create();

        $this->get(route('posts.show', $post))
             ->assertSeeText($post_title);
    }
}
