<?php

declare(strict_types=1);

namespace Tests\Feature\Listeners;

use App\Enums\BadgeName;
use App\Events\CommentApproved;
use App\Listeners\Badges\GiveUserCommentatorBadge;
use App\Models\Badge;
use App\Models\Comment;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class GiveUserCommentatorBadgeTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testListenerDoesntGiveUserABadgeIfHaveNotEnoughComments(): void
    {
        $user = $this->createUser();

        // Create commentator badge
        Badge::factory()->create(['name' => BadgeName::COMMENTATOR]);

        Comment::factory(9)->withPost()->create([
            'user_id' => $user->id,
        ]);

        $event = new CommentApproved($user);
        $listener = new GiveUserCommentatorBadge();

        $listener->handle($event);

        $this->assertTrue($user->badges()->doesntExist());
    }

    public function testListenerGivesUserABadgeIfHaveEnoughComments(): void
    {
        $user = $this->createUser();

        // Create commentator badge
        Badge::factory()->create(['name' => BadgeName::COMMENTATOR]);

        Comment::factory(10)->withPost()->create([
            'user_id' => $user->id,
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

        // Create commentator badge
        Badge::factory()->create(['name' => BadgeName::COMMENTATOR]);

        // Give user commentator badge
        $user->giveBadge(BadgeName::COMMENTATOR);

        Comment::factory(10)->withPost()->create([
            'user_id' => $user->id,
        ]);

        $event = new CommentApproved($user);
        $listener = new GiveUserCommentatorBadge();

        $listener->handle($event);

        $badges = $user->badges()->get();

        $this->assertCount(1, $badges);
        $this->assertSame(BadgeName::COMMENTATOR, $badges->first()?->name);
    }
}
