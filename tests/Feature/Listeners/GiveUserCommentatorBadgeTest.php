<?php

declare(strict_types=1);

namespace Tests\Feature\Listeners;

use App\Enums\BadgeName;
use App\Events\CommentApproved;
use App\Listeners\Badges\GiveUserCommentatorBadge;
use App\Models\Badge;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class GiveUserCommentatorBadgeTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testListenerDoesntGiveUserABadgeIfHaveNotEnoughComments(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        // Create commentator badge
        Badge::factory()->create(['name' => BadgeName::COMMENTATOR]);

        Comment::factory()->count(9)->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $event = new CommentApproved($user);
        $listener = new GiveUserCommentatorBadge();

        $listener->handle($event);

        $this->assertTrue($user->badges()->doesntExist());
    }

    public function testListenerGivesUserABadgeIfHaveEnoughComments(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        // Create commentator badge
        Badge::factory()->create(['name' => BadgeName::COMMENTATOR]);

        Comment::factory()->count(10)->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $event = new CommentApproved($user);
        $listener = new GiveUserCommentatorBadge();

        $listener->handle($event);

        $badges = $user->badges()->get();

        $this->assertCount(1, $badges);
        $this->assertSame(BadgeName::COMMENTATOR, $badges->first()?->name);
    }

    public function testListenerDoesntGiveUserABadgeIfHaveEnoughCommentsButAlreadyHasBadge(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        // Create commentator badge
        Badge::factory()->create(['name' => BadgeName::COMMENTATOR]);

        // Give user commentator badge
        $user->giveBadge(BadgeName::COMMENTATOR);

        Comment::factory()->count(10)->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $event = new CommentApproved($user);
        $listener = new GiveUserCommentatorBadge();

        $listener->handle($event);

        $badges = $user->badges()->get();

        $this->assertCount(1, $badges);
        $this->assertSame(BadgeName::COMMENTATOR, $badges->first()?->name);
    }
}
