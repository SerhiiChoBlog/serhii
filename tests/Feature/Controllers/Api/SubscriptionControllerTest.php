<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api;

use App\Models\Subscription;
use App\Notifications\ConfirmSubscription;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Notification;
use Tests\TestCase;

class SubscriptionControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_you_get_message_if_has_confirmed_subscription(): void
    {
        Notification::fake();

        $sub = Subscription::factory()->confirmed()->create();

        $response = $this->post("/api/subscriptions/{$sub->email}")
            ->getContent();

        $this->assertSame('Thank you! You are already subscribed. You will be notified when the new post is published', $response);

        Notification::assertNothingSent();
    }

    public function test_you_get_message_if_has_not_confirmed_subscription_created_today(): void
    {
        Notification::fake();

        $sub = Subscription::factory()->create();

        $response = $this->post("/api/subscriptions/{$sub->email}")
            ->getContent();

        $this->assertSame('Please, check you email to confirm the subscription, or try tomorrow', $response);

        Notification::assertNothingSent();
    }

    public function test_new_subscription_is_not_created_if_already_has_old_subscription(): void
    {
        Notification::fake();

        $sub = Subscription::factory()->create(['created_at' => now()->subDays(2)]);

        $response = $this->post("/api/subscriptions/{$sub->email}")
            ->getContent();

        $this->assertSame('Please, check you email to confirm your subscription', $response);

        Notification::assertTimesSent(1, ConfirmSubscription::class);

        $this->assertSame(1, Subscription::query()->count());
    }
}
