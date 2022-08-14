<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use App\Models\Subscription;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SubscriptionControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_you_can_confirm_subscription(): void
    {
        $sub = Subscription::factory()->create();

        $this->assertNull($sub->confirmed_at);

        $this->get(route('subscriptions.confirm', $sub->slug))
            ->assertViewIs('subscriptions.confirm');

        $this->assertNotNull($sub->fresh()->confirmed_at);
    }
}
