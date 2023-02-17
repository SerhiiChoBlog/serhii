<?php

declare(strict_types=1);

namespace Tests\Feature\Listeners;

use App\Enums\BadgeName;
use App\Listeners\Badges\GiveUserVerifiedBadge;
use App\Models\Badge;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class GiveUserVerifiedBadgeTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testUserGetsVerifiedBadge(): void
    {
        $user = $this->createUser();

        Badge::factory()->create(['name' => BadgeName::VERIFIED]);

        $event = new Verified($user);
        $listener = new GiveUserVerifiedBadge();

        $listener->handle($event);

        $badges = $user->badges()->get();

        $this->assertCount(1, $badges);
        $this->assertSame(BadgeName::VERIFIED, $badges->first()?->name);
    }
}
