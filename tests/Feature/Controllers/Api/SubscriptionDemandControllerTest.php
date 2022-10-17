<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api;

use App\Dto\Subscription\DemandResponse;
use App\Models\Subscription;
use App\Models\Tag;
use App\Notifications\ConfirmSubscription;
use App\Services\SubscriptionDemandService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Notification;
use Tests\TestCase;

class SubscriptionDemandControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_you_get_message_if_has_confirmed_subscription(): void
    {
        Notification::fake();

        $sub = Subscription::factory()->confirmed()->create();

        $response = $this->post('/api/subscriptions', [
            'email' => $sub->email,
            'tags' => '',
        ]);

        $expect = new DemandResponse(true, 'Thank you! You are already subscribed. You will be notified when the new post is published');

        $this->assertSame($expect->toArray(), $response->json());

        Notification::assertNothingSent();
    }

    public function test_you_get_message_if_has_not_confirmed_subscription_created_today(): void
    {
        Notification::fake();

        $sub = Subscription::factory()->create();

        $response = $this->post('/api/subscriptions', [
            'email' => $sub->email,
            'tags' => '',
        ]);

        $expect = new DemandResponse(true, 'Please, check you email to confirm the subscription, or try tomorrow');

        $this->assertSame($expect->toArray(), $response->json());

        Notification::assertNothingSent();
    }

    public function test_new_subscription_is_not_created_if_already_has_old_subscription(): void
    {
        Notification::fake();

        $sub = Subscription::factory()->create(['created_at' => now()->subDays(2)]);

        $response = $this->post('/api/subscriptions', [
            'email' => $sub->email,
            'tags' => '',
        ]);

        $expect = new DemandResponse(true, 'Please, check you email to confirm your subscription');

        $this->assertSame($expect->toArray(), $response->json());

        Notification::assertTimesSent(1, ConfirmSubscription::class);

        $this->assertSame(1, Subscription::query()->count());
    }

    public function test_subscription_can_be_created(): void
    {
        Notification::fake();

        $email = 'serhii@anna.com';

        $response = $this->post('/api/subscriptions', [
            'email' => $email,
            'tags' => '',
        ]);

        $expect = new DemandResponse(true, 'Please, check you email to confirm your subscription');

        $this->assertSame($expect->toArray(), $response->json());

        Notification::assertTimesSent(1, ConfirmSubscription::class);

        $this->assertSame(1, Subscription::query()->count());
        $this->assertDatabaseHas('subscriptions', compact('email'));
    }

    public function test_it_is_not_attaching_tags_when_requesting_all_tags(): void
    {
        Notification::fake();

        $this->post('/api/subscriptions', [
            'email' => 'anna@serhii.com',
            'tags' => SubscriptionDemandService::ALL_TAGS,
        ]);

        /** @var Subscription $sub */
        $sub = Subscription::with('tags')->first();

        $this->assertEmpty($sub->tags);
    }

    public function test_it_returns_warning_when_tags_are_not_selected(): void
    {
        Notification::fake();

        $response = $this->post('/api/subscriptions', [
            'email' => 'anna@serhii.com',
            'tags' => SubscriptionDemandService::NO_TAGS,
        ]);

        $expect = new DemandResponse(false, 'Choose tags to subscribe');

        $this->assertSame($expect->toArray(), $response->json());
    }

    public function test_it_attaches_tags_when_requesting_5_tags(): void
    {
        Notification::fake();

        /** @var Collection<int, Tag> $tags */
        $tags = Tag::factory()->count(5)->create();

        $this->post('/api/subscriptions', [
            'email' => 'serhii@anna.com',
            'tags' => $tags->pluck('id')->join(','),
        ]);

        /** @var Subscription $sub */
        $sub = Subscription::with('tags')->first();

        $this->assertCount(5, $sub->tags);
    }

    public function test_it_attaches_tags_when_requesting_1_tag(): void
    {
        Notification::fake();

        /** @var Tag $tag */
        $tag = Tag::factory()->create();

        $this->post('/api/subscriptions', [
            'email' => 'serhii@anna.com',
            'tags' => $tag->id,
        ]);

        /** @var Subscription $sub */
        $sub = Subscription::with('tags')->first();

        $this->assertCount(1, $sub->tags);
    }
}
