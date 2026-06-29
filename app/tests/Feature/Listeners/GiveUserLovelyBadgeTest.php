<?php

declare(strict_types=1);

namespace Tests\Feature\Listeners;

use App\Enums\BadgeName;
use App\Events\UserLikesPost;
use App\Listeners\Badges\GiveUserLovelyBadge;
use App\Models\Badge;
use App\Models\PostLike;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class GiveUserLovelyBadgeTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testListenerDoesntGiveUserABadgeIfHaveNotEnoughLikes(): void
    {
        $user = $this->createUser();

        Badge::factory()->create(['name' => BadgeName::LOVELY]);

        $like = PostLike::factory(9)->withPost()->create([
            'user_id' => $user->id,
        ]);

        $user->loadCount('postLikes');

        $event = new UserLikesPost($user, $like->first());
        $listener = new GiveUserLovelyBadge();

        $listener->handle($event);

        $this->assertTrue($user->badges()->doesntExist());
    }

    public function testListenerGivesUserABadgeIfHasEnoughLikes(): void
    {
        $user = $this->createUser();

        Badge::factory()->create(['name' => BadgeName::LOVELY]);

        $like = PostLike::factory(10)->withPost()->create([
            'user_id' => $user->id,
        ]);

        $user->loadCount('postLikes');

        $event = new UserLikesPost($user, $like->first());
        $listener = new GiveUserLovelyBadge();

        $listener->handle($event);

        $badges = $user->badges()->get();

        $this->assertCount(1, $badges);
        $this->assertSame(BadgeName::LOVELY, $badges->first()?->name);
    }

    public function testListenerDoesntGiveUserABadgeIfHasEnoughLikesButAlreadyHasBadge(): void
    {
        $user = $this->createUser();

        Badge::factory()->create(['name' => BadgeName::LOVELY]);

        $like = PostLike::factory(10)->withPost()->create([
            'user_id' => $user->id,
        ]);

        $user->giveBadge(BadgeName::LOVELY);
        $user->loadCount('postLikes');

        $event = new UserLikesPost($user, $like->first());
        $listener = new GiveUserLovelyBadge();

        $listener->handle($event);

        $badges = $user->badges()->get();

        $this->assertCount(1, $badges);
        $this->assertSame(BadgeName::LOVELY, $badges->first()?->name);
    }
}
