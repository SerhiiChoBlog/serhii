<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Feed;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use LazilyRefreshDatabase;

    private Comment $comment;
    private User $user;
    private Post $post;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->post = Post::factory()->create();

        $this->comment = Comment::factory()->create([
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function testCommentAlwaysHasUserAssociated(): void
    {
        $this->assertNotNull($this->comment->user);
        $this->assertSame($this->user->id, $this->comment->user->id);
    }

    public function testCommentAlwaysHasPostAssociated(): void
    {
        $this->assertNotNull($this->comment->post);
        $this->assertSame($this->post->id, $this->comment->post->id);
    }

    public function testCommentCanHaveLikes(): void
    {
        CommentLike::factory()->create([
            'user_id' => $this->user->id,
            'comment_id' => $this->comment->id,
        ]);

        $this->assertCount(1, $this->comment->likes);
    }

    public function testCommentHasRelationshipWithFeed(): void
    {
        $user = $this->createUser();

        $feed = Feed::factory()->create([
            'user_id' => $user,
            'comment_id' => $this->comment->id,
        ]);

        $this->assertSame($feed->id, $this->comment->feed->first()?->id);
    }

    public function testCommentCanHaveMultipleFeedItemsAttached(): void
    {
        $user = $this->createUser();
        $user2 = $this->createUser();

        Feed::factory()->create([
            'user_id' => $user,
            'comment_id' => $this->comment->id,
        ]);

        Feed::factory()->create([
            'user_id' => $user2,
            'comment_id' => $this->comment->id,
        ]);

        $this->assertCount(2, $this->comment->feed);
    }
}
