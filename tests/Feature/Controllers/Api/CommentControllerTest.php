<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const GET_COMMENTS_URI = '/api/comments/1';
    private const POST_COMMENT_URI = '/api/comments';

    public function test_you_can_get_comments(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $text = 'I like this post! Keep it up!';

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment' => $text,
        ]);

        $this->json('get', self::GET_COMMENTS_URI)
            ->assertOk()
            ->assertJsonFragment([
                'id' => $comment->id,
                'comment' => $text,
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
    }

    public function test_you_can_get_comments_with_nested_comments(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment' => 'I like this post! Keep it up!',
        ]);

        $nested_comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment' => $reply = 'I agree!',
            'comment_id' => $comment->id,
        ]);

        $this->json('get', self::GET_COMMENTS_URI)
             ->assertOk()
             ->assertJsonFragment([
                 'id' => $nested_comment->id,
                 'comment' => $reply,
                 'user_id' => $user->id,
                 'post_id' => $post->id,
                 'comment_id' => $comment->id,
             ]);
    }

    public function test_you_can_create_comment(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $text = 'Awesome post! Thank you for sharing your knowledge!';

        $this->json('post', self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => $text,
        ])
             ->assertOk();

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment' => $text,
        ]);
    }

    public function test_you_can_replay_to_comment(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $post = Post::factory()->create();

        // User 1 comments on a post
        $comment = Comment::factory()->create([
            'user_id' => $user1->id,
            'post_id' => $post->id,
            'comment' => 'Your posts are definitely worth reading! Thank you!',
        ]);

        // User 2 replies to User 1's comment
        $text = 'I agree with you! He is a great writer!';

        $this->json('post', self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user2->secret,
            'comment' => $text,
            'comment_id' => $comment->id,
        ])
            ->assertOk();

        $this->assertDatabaseHas('comments', [
            'user_id' => $user2->id,
            'post_id' => $post->id,
            'comment' => $text,
            'comment_id' => $comment->id,
        ]);
    }

    public function test_it_replies_to_parent_comment_after_replying_to_reply(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $post = Post::factory()->create();

        // User 1 comments on a post
        $comment = Comment::factory()->create([
            'user_id' => $user1->id,
            'post_id' => $post->id,
            'comment' => 'Your posts are definitely worth reading! Thank you!',
        ]);

        // User 2 replies to User 1's comment
        $reply = Comment::factory()->create([
            'user_id' => $user2->id,
            'post_id' => $post->id,
            'comment' => 'I agree with you! He is a great writer!',
            'comment_id' => $comment->id,
        ]);

        // User 3 replies to User 2's reply
        $text = 'I agree with you both!';

        $this->json('post', self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user3->secret,
            'comment' => $text,
            'comment_id' => $reply->id,
        ])
            ->assertOk();

        $this->assertDatabaseHas('comments', [
            'user_id' => $user3->id,
            'post_id' => $post->id,
            'comment' => $text,
            'comment_id' => $comment->id,
        ]);
    }

    public function test_user_cannot_create_comment_less_than_4_characters(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $resp = $this->json('post', self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => 'Hi!',
        ]);

        $resp->assertJsonValidationErrors('comment');
    }

    public function test_user_cannot_create_comment_more_than_1000_characters(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $resp = $this->json('post', self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => Str::random(1001),
        ]);

        $resp->assertJsonValidationErrors('comment');
    }

    public function test_user_can_create_comment_with_4_characters(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $resp = $this->json('post', self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => 'dude',
        ]);

        $resp->assertOk();
    }

    public function test_user_can_create_comment_with_1000_characters(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $resp = $this->json('post', self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => Str::random(1000),
        ]);

        $resp->assertOk();
    }
}
