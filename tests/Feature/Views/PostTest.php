<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\Post;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testGuestCanVisitPublishedPostPage(): void
    {
        $published_post = Post::factory()->published()->create();

        Visitor::factory()->create();

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

    public function testUserCannotSeeThePostIfItsNotPublished(): void
    {
        Visitor::factory()->create();

        $post = Post::factory()->create();
        $this->get(route('posts.show', $post))->assertNotFound();
    }

    public function testAdminCanSeeThePostIfItsNotPublished(): void
    {
        $user = User::factory()->make();
        $post = Post::factory()->create();

        $this->actingAs($user, 'admin')
            ->get(route('posts.show', $post))
            ->assertOk();
    }
}
