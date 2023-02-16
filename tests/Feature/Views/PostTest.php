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

    public function testGuestCanVisitPublishedPostPage(): void
    {
        $published_post = Post::factory()->published()->create();

        $this->get(route('posts.show', $published_post))
            ->assertOk()
            ->assertViewIs('posts.show');
    }

    public function testAdminCanVisitPage(): void
    {
        $published_post = Post::factory()->published()->create();
        $user = User::factory()->make();

        $this->actingAs($user, 'admin')
            ->get(route('posts.show', $published_post))
            ->assertOk()
            ->assertViewIs('posts.show');
    }

    public function testUserCanSeeThePostIfItsNotPublished(): void
    {
        $post = Post::factory()->create();
        $this->get(route('posts.show', $post))->assertSuccessful();
    }

    public function testAdminCanSeeThePostIfItsNotPublished(): void
    {
        $user = User::factory()->make();
        $post = Post::factory()->create();

        $this->actingAs($user, 'admin')
            ->get(route('posts.show', $post))
            ->assertOk();
    }

    public function testPostPageHasPostTitle(): void
    {
        $post_title = 'This is some nice title for the post';
        $post = Post::factory()->published()->title($post_title)->create();

        $this->get(route('posts.show', $post))
            ->assertSeeText($post_title);
    }
}
