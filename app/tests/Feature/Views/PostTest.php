<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\Post;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Http;
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

    public function testKnownVisitorDoesNotSendRequestToGeolocationApi(): void
    {
        Http::fake();

        $published_post = Post::factory()->published()->create();

        Visitor::factory()->create(['ip' => '8.8.8.8']);

        $this->withServerVariables(['REMOTE_ADDR' => '8.8.8.8'])
            ->get(route('posts.show', $published_post))
            ->assertOk();

        Http::assertNothingSent();
    }

    public function testAdminCanVisitPage(): void
    {
        $published_post = Post::factory()->published()->create();

        /** @var User $user */
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
        /** @var User $user */
        $user = User::factory()->make();

        /** @var Post $post */
        $post = Post::factory()->create();

        $this->actingAs($user, 'admin')
            ->get(route('posts.show', $post))
            ->assertOk();
    }
}
