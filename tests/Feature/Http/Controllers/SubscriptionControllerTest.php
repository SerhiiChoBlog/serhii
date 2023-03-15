<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class SubscriptionControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testYouCanConfirmSubscription(): void
    {
        $sub = Subscription::factory()->create();

        $this->assertNull($sub->confirmed_at);

        $this->get(route('subscriptions.confirm', $sub->slug))
            ->assertViewIs('subscriptions.confirm');

        $this->assertNotNull($sub->fresh()->confirmed_at);
    }

    public function testYouWillBeRedirectedIfSubscriptionNotFound(): void
    {
        $this->get(route('subscriptions.confirm', 'ilskfjas'))
            ->assertRedirect(route('subscriptions.error'));
    }

    public function testYouCanDeclineSubscription(): void
    {
        $sub = Subscription::factory()->create();

        $this->get(route('subscriptions.decline', $sub->slug))
            ->assertViewIs('subscriptions.decline');

        $this->assertDatabaseMissing('subscriptions', [
            'id' => $sub->id,
        ]);
    }

    public function testIfSubscriptionNotFoundItWillStillShowDeclinePage(): void
    {
        $this->get(route('subscriptions.decline', 'sdfsdfaj'))
            ->assertViewIs('subscriptions.decline');
    }
}
