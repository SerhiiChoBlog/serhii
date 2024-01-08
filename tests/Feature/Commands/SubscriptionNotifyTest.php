<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use App\Models\Post;
use App\Models\PostPublication;
use App\Models\Subscription;
use App\Models\Tag;
use App\Notifications\PostPublished;
use Exception;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SubscriptionNotifyTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    private function finalNotificationMessage(Post $post, int $notified, ?int $skipped = 0): string
    {
        return <<<TEXT
        - Notified: {$notified} subscribers;
        - Skipped: {$skipped} subscribers;
        Post published:
        "{$post->title}"
        TEXT;
    }

    public function testCannotNotifyPostPublicationWhenItIsAlreadyNotified(): void
    {
        $post = Post::factory()->published()->create();
        Subscription::factory()->confirmed()->create();

        PostPublication::query()->create(['post_id' => $post->id]);

        $this->artisan('subscriptions:notify')
            ->expectsOutput("Subscribers were already notified with post:\n\"{$post->title}\"")
            ->assertFailed();

        Notification::assertNothingSent();
    }

    public function test2SubscribersAreNotifiedWhenWithNewPost(): void
    {
        $post = Post::factory()->published()->create();
        Subscription::factory(2)->confirmed()->create();

        $this->artisan('subscriptions:notify')
            ->expectsOutput($this->finalNotificationMessage($post, 2))
            ->assertSuccessful();

        $this->assertDatabaseHas('post_publications', ['people_notified' => 2]);
        $this->assertSame(1, PostPublication::query()->count());
    }

    public function testExceptionIsThrownWhenThereAreNoPosts(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('There are no posts in database');

        Subscription::factory()->confirmed()->create();

        $this->artisan('subscriptions:notify');

        $this->assertDatabaseHas('post_publications', ['people_notified' => 2]);
        $this->assertSame(1, PostPublication::query()->count());
    }

    public function test1SubscriberIsNotifiedWhenWithNewPost(): void
    {
        $post = Post::factory()->published()->create();
        $sub = Subscription::factory()->confirmed()->create();

        $this->artisan('subscriptions:notify')
            ->expectsOutput($this->finalNotificationMessage($post, 1))
            ->assertSuccessful();

        $this->assertDatabaseHas('post_publications', ['people_notified' => 1]);
        $this->assertSame(1, PostPublication::query()->count());
    }

    public function testEachPersonIsNotifiedViaEmail(): void
    {
        $post = Post::factory()->published()->create();
        $subs = Subscription::factory(3)->confirmed()->create();

        $this->artisan('subscriptions:notify')
            ->expectsOutput($this->finalNotificationMessage($post, 3))
            ->assertSuccessful();

        Notification::assertSentTimes(PostPublished::class, 3);
    }

    public function testSubsAreNotifiedWithCorrectPost(): void
    {
        Post::factory()->published()->title('First')->create(['created_at' => now()->subDay()]);
        Post::factory()->published()->title('Second')->create(['created_at' => now()->subDays(10)]);
        Post::factory()->published()->title('Third')->create(['created_at' => now()->subMonth()]);
        $post = Post::factory()->published()->title('Last one')->create(['created_at' => now()->subHour()]);

        Subscription::factory(3)->confirmed()->create();

        $this->artisan('subscriptions:notify')
            ->expectsOutput($this->finalNotificationMessage($post, 3))
            ->assertSuccessful();

        Notification::assertSentTimes(PostPublished::class, 3);
    }

    public function testNoNotificationsWithoutSubscribers(): void
    {
        Post::factory()->published()->create();

        $this->artisan('subscriptions:notify')
            ->expectsOutput("No subscriptions")
            ->assertFailed();

        $this->assertSame(0, PostPublication::query()->count());

        Notification::assertNothingSent();
    }

    public function testNotConfirmedSubscriptionsAreNotNotified(): void
    {
        Post::factory()->published()->create();

        Subscription::factory(3)->create();
        Subscription::factory()->confirmed()->create();

        $this->artisan('subscriptions:notify')->assertSuccessful();

        $this->assertSame(1, PostPublication::query()->count());

        Notification::assertSentTimes(PostPublished::class, 1);
    }

    public function testIfSubscriberIsNotSubscribedToTagTheyAreNotNotified(): void
    {
        $tag1 = Tag::factory()->create();
        $tag2 = Tag::factory()->create();

        $post_tag1 = Tag::factory()->create();
        $post_tag2 = Tag::factory()->create();

        /** @var Post $post */
        $post = Post::factory()->published()->create();
        $post->tags()->attach([$post_tag1->id, $post_tag2->id]);

        /** @var Subscription $subscriber */
        $subscriber = Subscription::factory()->confirmed()->create();
        $subscriber->tags()->attach([$tag1->id, $tag2->id]);

        $this->artisan('subscriptions:notify')->assertSuccessful();

        /** @var PostPublication $publication */
        $publication = PostPublication::query()->first();

        $this->assertSame(0, $publication->people_notified);

        Notification::assertSentTimes(PostPublished::class, 0);
    }

    public function testIfSubscriberIsSubscribedToTagTheyWillBeNotified(): void
    {
        $tag1 = Tag::factory()->create();
        $tag2 = Tag::factory()->create();

        /** @var Post $post */
        $post = Post::factory()->published()->create();
        $post->tags()->attach([$tag1->id, $tag2->id]);

        /** @var Subscription $subscriber */
        $subscriber = Subscription::factory()->confirmed()->create();
        $subscriber->tags()->attach([$tag1->id]);

        $this->artisan('subscriptions:notify')->assertSuccessful();

        /** @var PostPublication $publication */
        $publication = PostPublication::query()->first();

        $this->assertSame(1, $publication->people_notified);

        Notification::assertSentTimes(PostPublished::class, 1);
    }

    public function testIfSubscriberIsSubscribedToLastTagInThePostTheyWillReceiveEmail(): void
    {
        $tag1 = Tag::factory()->create();
        $tag2 = Tag::factory()->create();
        $last_tag = Tag::factory()->create();

        /** @var Post $post */
        $post = Post::factory()->published()->create();
        $post->tags()->attach([$tag1->id, $tag2->id, $last_tag->id]);

        /** @var Subscription $subscriber */
        $subscriber = Subscription::factory()->confirmed()->create();
        $subscriber->tags()->attach([$last_tag->id]);

        $this->artisan('subscriptions:notify')->assertSuccessful();

        /** @var PostPublication $publication */
        $publication = PostPublication::query()->first();

        $this->assertSame(1, $publication->people_notified);

        Notification::assertSentTimes(PostPublished::class, 1);
    }

    public function testIfSubscriberIsSubscribedToTheFirstTagInThePostTheyWillReceiveEmail(): void
    {
        $first_tag = Tag::factory()->create();
        $tag2 = Tag::factory()->create();
        $tag3 = Tag::factory()->create();

        /** @var Post $post */
        $post = Post::factory()->published()->create();
        $post->tags()->attach([$first_tag->id, $tag2->id, $tag3->id]);

        /** @var Subscription $subscriber */
        $subscriber = Subscription::factory()->confirmed()->create();
        $subscriber->tags()->attach([$first_tag->id]);

        $this->artisan('subscriptions:notify')->assertSuccessful();

        /** @var PostPublication $publication */
        $publication = PostPublication::query()->first();

        $this->assertSame(1, $publication->people_notified);

        Notification::assertSentTimes(PostPublished::class, 1);
    }
}
