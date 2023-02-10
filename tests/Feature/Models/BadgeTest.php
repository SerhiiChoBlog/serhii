<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Enums\BadgeName;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class BadgeTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_badge_can_be_created(): void
    {
        Badge::factory()->create(['name' => BadgeName::VERIFIED]);
        $this->assertDatabaseHas('badges', ['name' => BadgeName::VERIFIED]);
    }

    public function test_badge_has_users_associated(): void
    {
        /** @var Badge $badge */
        $badge = Badge::factory()->create();

        /** @var User $user */
        $user = User::factory()->create();

        $badge->users()->attach([$user->id]);

        $this->assertCount(1, $badge->users);
    }
}
