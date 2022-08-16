<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use App\Models\Post;
use App\Models\PostPublication;
use App\Models\Subscription;
use App\Notifications\PostPublished;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SubscriptionNotifyTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    public function test_cannot_notify_post_publication_when_it_is_already_notified(): void
    {
        $post = Post::factory()->published()->create();

        PostPublication::query()->create(['post_id' => $post->id]);

        $this->artisan('subscriptions:notify')
            ->expectsOutput("Subscribers were already notified with post:\n\"$post->title\"")
            ->assertFailed();

        Notification::assertNothingSent();
    }

    public function test_2_subscribers_are_notified_when_with_new_post(): void
    {
        $post = Post::factory()->published()->create();
        Subscription::factory()->count(2)->confirmed()->create();

        $this->artisan('subscriptions:notify')
            ->expectsOutput("2 subscribers were successfully notified with post:\n\"$post->title\"")
            ->assertSuccessful();

        $this->assertDatabaseHas('post_publications', ['people_notified' => 2]);
        $this->assertSame(1, PostPublication::query()->count());
    }

    public function test_exception_is_thrown_when_there_are_no_posts(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('There are no posts in database');

        $this->artisan('subscriptions:notify');

        $this->assertDatabaseHas('post_publications', ['people_notified' => 2]);
        $this->assertSame(1, PostPublication::query()->count());
    }

    public function test_1_subscriber_is_notified_when_with_new_post(): void
    {
        $post = Post::factory()->published()->create();
        $sub = Subscription::factory()->confirmed()->create();

        $this->artisan('subscriptions:notify')
            ->expectsOutput("1 subscribers were successfully notified with post:\n\"$post->title\"")
            ->assertSuccessful();

        $this->assertDatabaseHas('post_publications', ['people_notified' => 1]);
        $this->assertSame(1, PostPublication::query()->count());
    }

    public function test_each_person_is_notified_via_email(): void
    {
        $post = Post::factory()->published()->create();
        $subs = Subscription::factory()->count(3)->confirmed()->create();

        $this->artisan('subscriptions:notify')
            ->expectsOutput("3 subscribers were successfully notified with post:\n\"$post->title\"")
            ->assertSuccessful();

        Notification::assertTimesSent(3, PostPublished::class);
    }

    public function test_subs_are_notified_with_correct_post(): void
    {
        Post::factory()->published()->title('First')->create(['created_at' => now()->subDay()]);
        Post::factory()->published()->title('Second')->create(['created_at' => now()->subDays(10)]);
        Post::factory()->published()->title('Third')->create(['created_at' => now()->subMonth()]);
        $latest_post = Post::factory()->published()->title('Last one')->create(['created_at' => now()->subHour()]);

        $subs = Subscription::factory()->count(3)->confirmed()->create();

        $this->artisan('subscriptions:notify')
            ->expectsOutput("3 subscribers were successfully notified with post:\n\"$latest_post->title\"")
            ->assertSuccessful();

        Notification::assertTimesSent(3, PostPublished::class);
    }
}
