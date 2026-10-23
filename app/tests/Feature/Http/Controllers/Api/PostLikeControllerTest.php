<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api;

use App\Enums\FeedType;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class PostLikeControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const STORE_LIKE_URI = '/api/post-likes';
    private const IS_LIKED_URI = '/api/post-likes/is-liked';

    private User $user;
    private Post $post;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->post = Post::factory()->create();
    }

    public function testUserCanLikePost(): void
    {
        $this->actingAs($this->user, 'user')
            ->postJson(self::STORE_LIKE_URI, [
                'post_id' => $this->post->id,
            ])
            ->assertOk()
            ->assertJson(['liked' => true, 'likes' => 1]);

        $this->assertDatabaseHas('post_likes', [
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function testUserCantUnlikePost(): void
    {
        PostLike::factory()->create([
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user, 'user')
            ->postJson(self::STORE_LIKE_URI, [
                'post_id' => $this->post->id,
            ])
            ->assertOk()
            ->assertJson(['liked' => true, 'likes' => 1]);

        $this->assertDatabaseHas('post_likes', [
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function testServerReturnsValidationErrorIfPostIdDoesntExist(): void
    {
        $this->actingAs($this->user, 'user')
            ->postJson(self::STORE_LIKE_URI, [
                'post_id' => 999,
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['post_id']);
    }

    public function testReturnsTrueIfPostIsLiked(): void
    {
        PostLike::factory()->create([
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
        ]);

        $query = http_build_query([
            'post_id' => $this->post->id,
        ]);

        $this->actingAs($this->user, 'user')
            ->getJson(self::IS_LIKED_URI . '?' . $query)
            ->assertOk()
            ->assertJson(['liked' => true, 'likes' => 1]);
    }

    public function testReturnsFalseIfPostIsNotLiked(): void
    {
        $this->user = $this->createUser();

        $query = http_build_query([
            'post_id' => $this->post->id,
        ]);

        $this->actingAs($this->user, 'user')
            ->getJson(self::IS_LIKED_URI . '?' . $query)
            ->assertOk()
            ->assertJson(['liked' => false, 'likes' => 0]);
    }

    public function testLikingPostCreatesFeedItem(): void
    {
        $this->user = $this->createUser();
        $this->user->loadCount('postLikes');

        $this->actingAs($this->user, 'user')
            ->postJson(self::STORE_LIKE_URI, [
                'post_id' => $this->post->id,
            ]);

        $this->assertDatabaseHas('feed', [
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
            'type' => FeedType::POST_LIKE,
        ]);
    }

}
