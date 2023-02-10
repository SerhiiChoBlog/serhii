<?php

declare(strict_types=1);

namespace Tests\Feature\Listeners;

use App\Enums\BadgeName;
use App\Events\CommentApproved;
use App\Listeners\GiveUserCommentatorBadge;
use App\Models\Badge;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class GiveUserCommentatorBadgeTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_listener_doesnt_give_user_a_badge_if_have_not_enough_comments(): void
    {
        $user = User::factory()->create();
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

    public function test_listener_gives_user_a_badge_if_have_enough_comments(): void
    {
        $user = User::factory()->create();
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
}
