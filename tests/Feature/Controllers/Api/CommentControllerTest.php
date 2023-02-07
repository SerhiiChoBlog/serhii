<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
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

        $this->get(self::GET_COMMENTS_URI)
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

        $this->get(self::GET_COMMENTS_URI)
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

        $this->post(self::POST_COMMENT_URI, [
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

        $this->post(self::POST_COMMENT_URI, [
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
}
