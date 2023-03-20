<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\Post;
use App\Models\PostLike;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testUserCanVisitUserProfile(): void
    {
        $user = $this->createUser();

        $this->actingAs($user, 'user')
            ->get(RouteServiceProvider::USER_HOME)
            ->assertOk();
    }

    public function testAdminCannotVisitUserProfile(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get(RouteServiceProvider::USER_HOME)
            ->assertRedirectToRoute('login');
    }

    public function testGuestCannotVisitUserProfile(): void
    {
        $this->get(RouteServiceProvider::USER_HOME)->assertRedirectToRoute('login');
    }

    public function testCanHaveLikes(): void
    {
        $user = $this->createUser();

        /** @var Post $post */
        $post = Post::factory()->create();

        PostLike::factory()->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        $this->assertCount(1, $user->likes);
    }

    public function testUserHasLikePostMethod(): void
    {
        $user = $this->createUser();

        /** @var Post $post_one */
        $post_one = Post::factory()->create();

        // Not liked post
        Post::factory()->create();

        $user->likePost($post_one->id);

        $this->assertCount(1, $user->likes);
    }
}
