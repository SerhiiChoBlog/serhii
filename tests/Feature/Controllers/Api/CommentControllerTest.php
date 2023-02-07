<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const GET_COMMENTS_URI = '/api/comments/1';

    public function test_you_can_get_comments(): void
    {
        $user = User::factory()->create();
        $visitor = Visitor::factory()->create();
        $post = Post::factory()->create();

        $text = 'I like this post! Keep it up!';

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'visitor_id' => $visitor->id,
            'comment' => $text,
        ]);

        $this->get(self::GET_COMMENTS_URI)
            ->assertOk()
            ->assertJsonFragment([
                'id' => $comment->id,
                'comment' => $text,
                'user_id' => $user->id,
                'post_id' => $post->id,
                'visitor_id' => $visitor->id,
            ]);
    }

    public function test_you_can_get_comments_with_nested_comments(): void
    {
        $user = User::factory()->create();
        $visitor = Visitor::factory()->create();
        $post = Post::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'visitor_id' => $visitor->id,
            'comment' => 'I like this post! Keep it up!',
        ]);

        $nested_comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'visitor_id' => $visitor->id,
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
                 'visitor_id' => $visitor->id,
             ]);
    }
}
