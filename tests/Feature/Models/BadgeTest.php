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

    public function testBadgeCanBeCreated(): void
    {
        Badge::factory()->create(['name' => BadgeName::VERIFIED]);
        $this->assertDatabaseHas('badges', ['name' => BadgeName::VERIFIED]);
    }

    public function testBadgeHasUsersAssociated(): void
    {
        /** @var Badge $badge */
        $badge = Badge::factory()->create();

        $user = $this->createUser();

        $badge->users()->attach([$user->id]);

        $this->assertCount(1, $badge->users);
    }
}
