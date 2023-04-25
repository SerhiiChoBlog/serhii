<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Enums\FeedType;
use App\Models\Feed;
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

    }
}
