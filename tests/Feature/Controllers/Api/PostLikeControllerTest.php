<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class PostLikeControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const STORE_COMMENT_URI = '/api/post-likes';

    public function testUserCanLikePost(): void
    {
        $user = $this->createUser();

        /** @var Post $post */
        $post = Post::factory()->create();

        $this->actingAs($user, 'user')
            ->postJson(self::STORE_COMMENT_URI, [
                'post_id' => $post->id,
                'secret' => $user->secret,
            ])
            ->assertOk()
            ->assertJson(['liked' => true]);

        $this->assertDatabaseHas('post_likes', [
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
    }

    public function testUserCanUnlikePost(): void
    {
        $user = $this->createUser();

        /** @var Post $post */
        $post = Post::factory()->create();

        PostLike::factory()->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        $this->actingAs($user, 'user')
            ->postJson(self::STORE_COMMENT_URI, [
                'post_id' => $post->id,
                'secret' => $user->secret,
            ])
            ->assertOk()
            ->assertJson(['liked' => false]);

        $this->assertDatabaseMissing('post_likes', [
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
    }

    public function testServerReturnsValidationErrorIfPostIdDoesntExist(): void
    {
        $user = $this->createUser();

        $this->actingAs($user, 'user')
            ->postJson(self::STORE_COMMENT_URI, [
                'post_id' => 999,
                'secret' => $user->secret,
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['post_id']);
    }
}
