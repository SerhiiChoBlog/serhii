<?php

declare(strict_types=1);

namespace Tests\Feature\Listeners;

use App\Enums\BadgeName;
use App\Events\UserLikesPost;
use App\Listeners\Badges\GiveUserLovelyBadge;
use App\Models\Badge;
use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class GiveUserLovelyBadgeTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testListenerDoesntGiveUserABadgeIfHaveNotEnoughLikes(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        Badge::factory()->create(['name' => BadgeName::LOVELY]);

        PostLike::factory()->count(9)->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $event = new UserLikesPost($user);
        $listener = new GiveUserLovelyBadge();

        $listener->handle($event);

        $this->assertTrue($user->badges()->doesntExist());
    }

    public function testListenerGivesUserABadgeIfHaveEnoughLikes(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        Badge::factory()->create(['name' => BadgeName::LOVELY]);

        PostLike::factory()->count(10)->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $event = new UserLikesPost($user);
        $listener = new GiveUserLovelyBadge();

        $listener->handle($event);

        $badges = $user->badges()->get();

        $this->assertCount(1, $badges);
        $this->assertSame(BadgeName::LOVELY, $badges->first()?->name);
    }
}
