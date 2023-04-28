<?php

declare(strict_types=1);

namespace Tests\Feature\Listeners;

use App\Enums\BadgeName;
use App\Events\UserUnlikesPost;
use App\Listeners\Badges\RemoveLovelyBadgeFromUser;
use App\Models\Badge;
use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class RemoveLovelyBadgeFromUserTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testListenerDoesntRemoveBadgeFromUserIfHaveEnoughLikes(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        Badge::factory()->create(['name' => BadgeName::LOVELY]);

        PostLike::factory()->count(10)->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $user->giveBadge(BadgeName::LOVELY);
        $user->loadCount('postLikes');

        $event = new UserUnlikesPost($user, $post->id);
        $listener = new RemoveLovelyBadgeFromUser();

        $listener->handle($event);

        $this->assertSame(1, $user->badges()->count());
    }

    public function testListenerRemovesBadgeFromUserIfDoesntHaveEnoughLikes(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        Badge::factory()->create(['name' => BadgeName::LOVELY]);

        PostLike::factory()->count(9)->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $user->loadCount('postLikes');
        $user->giveBadge(BadgeName::LOVELY);

        $event = new UserUnlikesPost($user, $post->id);
        $listener = new RemoveLovelyBadgeFromUser();

        $listener->handle($event);

        $badges = $user->badges()->get();

        $this->assertCount(0, $badges);
        $this->assertTrue(Badge::query()->where('name', BadgeName::LOVELY)->exists());
    }

    public function testListenerDoesntRemoveOtherBadgesFromUserIfHasOtherBadges(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        Badge::factory()->create(['name' => BadgeName::LOVELY]);
        Badge::factory()->create(['name' => BadgeName::VERIFIED]);
        Badge::factory()->create(['name' => BadgeName::COMMENTATOR]);

        PostLike::factory()->count(9)->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $user->loadCount('postLikes');
        $user->giveBadge(BadgeName::LOVELY);
        $user->giveBadge(BadgeName::VERIFIED);
        $user->giveBadge(BadgeName::COMMENTATOR);

        $event = new UserUnlikesPost($user, $post->id);
        $listener = new RemoveLovelyBadgeFromUser();

        $listener->handle($event);

        $badges = $user->badges()->get();

        $this->assertCount(2, $badges);
    }

    public function testListenerDoesntRemoveBadgeFromUserIfHasOtherBadgesAndEnoughLikes(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        Badge::factory()->create(['name' => BadgeName::LOVELY]);
        Badge::factory()->create(['name' => BadgeName::VERIFIED]);
        Badge::factory()->create(['name' => BadgeName::COMMENTATOR]);

        PostLike::factory()->count(10)->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $user->loadCount('postLikes');
        $user->giveBadge(BadgeName::LOVELY);
        $user->giveBadge(BadgeName::VERIFIED);
        $user->giveBadge(BadgeName::COMMENTATOR);

        $event = new UserUnlikesPost($user, $post->id);
        $listener = new RemoveLovelyBadgeFromUser();

        $listener->handle($event);

        $badges = $user->badges()->get();

        $this->assertCount(3, $badges);
    }
}
