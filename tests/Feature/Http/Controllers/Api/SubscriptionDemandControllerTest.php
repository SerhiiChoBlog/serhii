<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api;

use App\Dto\Subscription\DemandResponse;
use App\Models\Subscription;
use App\Models\Tag;
use App\Notifications\ConfirmSubscription;
use App\Services\SubscriptionDemandService;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SubscriptionDemandControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testYouGetMessageIfHasConfirmedSubscription(): void
    {
        Notification::fake();

        $sub = Subscription::factory()->confirmed()->create();

        $response = $this->postJson('/api/subscriptions', [
            'email' => $sub->email,
            'tags' => '',
        ]);

        $expect = new DemandResponse(true, 'Thank you! You are already subscribed. You will be notified when the new post is published');

        $this->assertSame($expect->toArray(), $response->json());

        Notification::assertNothingSent();
    }

    public function testYouGetMessageIfHasNotConfirmedSubscriptionCreatedToday(): void
    {
        Notification::fake();

        $sub = Subscription::factory()->create();

        $response = $this->postJson('/api/subscriptions', [
            'email' => $sub->email,
            'tags' => '',
        ]);

        $expect = new DemandResponse(true, 'Please, check you email to confirm the subscription, or try tomorrow');

        $this->assertSame($expect->toArray(), $response->json());

        Notification::assertNothingSent();
    }

    public function testNewSubscriptionIsNotCreatedIfAlreadyHasOldSubscription(): void
    {
        Notification::fake();

        $sub = Subscription::factory()->create(['created_at' => now()->subDays(2)]);

        $response = $this->postJson('/api/subscriptions', [
            'email' => $sub->email,
            'tags' => '',
        ]);

        $expect = new DemandResponse(true, 'Please, check you email to confirm your subscription');

        $this->assertSame($expect->toArray(), $response->json());

        Notification::assertSentTimes(ConfirmSubscription::class, 1);

        $this->assertSame(1, Subscription::query()->count());
    }

    public function testSubscriptionCanBeCreated(): void
    {
        Notification::fake();

        $email = 'serhii@anna.com';

        $response = $this->postJson('/api/subscriptions', [
            'email' => $email,
            'tags' => '',
        ]);

        $expect = new DemandResponse(true, 'Please, check you email to confirm your subscription');

        $this->assertSame($expect->toArray(), $response->json());

        Notification::assertSentTimes(ConfirmSubscription::class, 1);

        $this->assertSame(1, Subscription::query()->count());
        $this->assertDatabaseHas('subscriptions', compact('email'));
    }

    public function testItIsNotAttachingTagsWhenRequestingAllTags(): void
    {
        Notification::fake();

        $this->postJson('/api/subscriptions', [
            'email' => 'anna@serhii.com',
            'tags' => SubscriptionDemandService::ALL_TAGS,
        ]);

        /** @var Subscription $sub */
        $sub = Subscription::with('tags')->first();

        $this->assertEmpty($sub->tags);
    }

    public function testItReturnsWarningWhenTagsAreNotSelected(): void
    {
        Notification::fake();

        $response = $this->postJson('/api/subscriptions', [
            'email' => 'anna@serhii.com',
            'tags' => SubscriptionDemandService::NO_TAGS,
        ]);

        $expect = new DemandResponse(false, 'Choose tags to subscribe');

        $this->assertSame($expect->toArray(), $response->json());
    }

    public function testItAttachesTagsWhenRequesting5Tags(): void
    {
        Notification::fake();

        /** @var Collection<int, Tag> $tags */
        $tags = Tag::factory()->count(5)->create();

        $this->postJson('/api/subscriptions', [
            'email' => 'serhii@anna.com',
            'tags' => $tags->implode('id', ',')
        ]);

        /** @var Subscription $sub */
        $sub = Subscription::with('tags')->first();

        $this->assertCount(5, $sub->tags);
    }

    public function testItAttachesTagsWhenRequesting1Tag(): void
    {
        Notification::fake();

        /** @var Tag $tag */
        $tag = Tag::factory()->create();

        $this->postJson('/api/subscriptions', [
            'email' => 'serhii@anna.com',
            'tags' => $tag->id,
        ]);

        /** @var Subscription $sub */
        $sub = Subscription::with('tags')->first();

        $this->assertCount(1, $sub->tags);
    }
}
