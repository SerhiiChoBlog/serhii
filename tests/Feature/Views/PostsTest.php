<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class PostsTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testGuestCanVisitPage(): void
    {
        $this->get(route('posts.index'))->assertOk()->assertViewIs('posts.index');
    }

    public function testAdminCanVisitPage(): void
    {
        /** @var User $user */
        $user = User::factory()->make();

        $this->actingAs($user, 'admin')
            ->get(route('posts.index'))
            ->assertOk()
            ->assertViewIs('posts.index');
    }

    public function testBlogPageRedirectsToPosts(): void
    {
        $this->get('/blog')->assertRedirect(route('posts.index'));
    }
}
