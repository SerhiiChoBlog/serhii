<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Enums\FeedType;
use App\Models\Badge;
use App\Models\Comment;
use App\Models\Feed;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class FeedTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testFeedTypeIsEnum(): void
    {
        $user = $this->createUser();
        $feed = Feed::factory()->create(['user_id' => $user]);

        $this->assertInstanceOf(FeedType::class, $feed->type);
    }

    public function testFeedHasRelationshipWithUser(): void
    {
        $user = $this->createUser();
        $feed = Feed::factory()->create(['user_id' => $user]);

        $this->assertInstanceOf(User::class, $feed->user);
    }

    public function testFeedHasRelationshipWithComment(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user, 'post_id' => $post]);

        $feed = Feed::factory()->create([
            'user_id' => $user,
            'comment_id' => $comment,
        ]);

        $this->assertInstanceOf(Comment::class, $feed->comment);
    }

    public function testFeedHasRelationshipWithPost(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        $feed = Feed::factory()->create([
            'user_id' => $user,
            'post_id' => $post,
        ]);

        $this->assertInstanceOf(Post::class, $feed->post);
    }

    public function testFeedHasRelationshipWithBadge(): void
    {
        $user = $this->createUser();
        $badge = Badge::factory()->create();

        $feed = Feed::factory()->create([
            'user_id' => $user,
            'badge_id' => $badge,
        ]);

        $this->assertInstanceOf(Badge::class, $feed->badge);
    }
}
