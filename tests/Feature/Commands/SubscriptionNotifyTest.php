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
        "$post->title"
        TEXT;
    }

    public function test_cannot_notify_post_publication_when_it_is_already_notified(): void
    {
        $post = Post::factory()->published()->create();
        Subscription::factory()->confirmed()->create();

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
            ->expectsOutput($this->finalNotificationMessage($post, 2))
            ->assertSuccessful();

        $this->assertDatabaseHas('post_publications', ['people_notified' => 2]);
        $this->assertSame(1, PostPublication::query()->count());
    }

    public function test_exception_is_thrown_when_there_are_no_posts(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('There are no posts in database');

        Subscription::factory()->confirmed()->create();

        $this->artisan('subscriptions:notify');

        $this->assertDatabaseHas('post_publications', ['people_notified' => 2]);
        $this->assertSame(1, PostPublication::query()->count());
    }

    public function test_1_subscriber_is_notified_when_with_new_post(): void
    {
        $post = Post::factory()->published()->create();
        $sub = Subscription::factory()->confirmed()->create();

        $this->artisan('subscriptions:notify')
            ->expectsOutput($this->finalNotificationMessage($post, 1))
            ->assertSuccessful();

        $this->assertDatabaseHas('post_publications', ['people_notified' => 1]);
        $this->assertSame(1, PostPublication::query()->count());
    }

    public function test_each_person_is_notified_via_email(): void
    {
        $post = Post::factory()->published()->create();
        $subs = Subscription::factory()->count(3)->confirmed()->create();

        $this->artisan('subscriptions:notify')
            ->expectsOutput($this->finalNotificationMessage($post, 3))
            ->assertSuccessful();

        Notification::assertTimesSent(3, PostPublished::class);
    }

    public function test_subs_are_notified_with_correct_post(): void
    {
        Post::factory()->published()->title('First')->create(['created_at' => now()->subDay()]);
        Post::factory()->published()->title('Second')->create(['created_at' => now()->subDays(10)]);
        Post::factory()->published()->title('Third')->create(['created_at' => now()->subMonth()]);
        $post = Post::factory()->published()->title('Last one')->create(['created_at' => now()->subHour()]);

        Subscription::factory()->count(3)->confirmed()->create();

        $this->artisan('subscriptions:notify')
            ->expectsOutput($this->finalNotificationMessage($post, 3))
            ->assertSuccessful();

        Notification::assertTimesSent(3, PostPublished::class);
    }

    public function test_no_notifications_without_subscribers(): void
    {
        Post::factory()->published()->create();

        $this->artisan('subscriptions:notify')
            ->expectsOutput("No subscriptions")
            ->assertFailed();

        $this->assertSame(0, PostPublication::query()->count());

        Notification::assertNothingSent();
    }

    public function test_not_confirmed_subscriptions_are_not_notified(): void
    {
        Post::factory()->published()->create();

        Subscription::factory()->count(3)->create();
        Subscription::factory()->confirmed()->create();

        $this->artisan('subscriptions:notify')->assertSuccessful();

        $this->assertSame(1, PostPublication::query()->count());

        Notification::assertTimesSent(1, PostPublished::class);
    }

    public function test_if_subscriber_is_not_subscribed_to_tag_they_are_not_notified(): void
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

        Notification::assertTimesSent(0, PostPublished::class);
    }

    public function test_if_subscriber_is_subscribed_to_tag_they_will_be_notified(): void
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

        Notification::assertTimesSent(1, PostPublished::class);
    }

    public function test_if_subscriber_is_subscribed_to_last_tag_in_the_post_they_will_receive_email(): void
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

        Notification::assertTimesSent(1, PostPublished::class);
    }

    public function test_if_subscriber_is_subscribed_to_the_first_tag_in_the_post_they_will_receive_email(): void
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

        Notification::assertTimesSent(1, PostPublished::class);
    }
}
