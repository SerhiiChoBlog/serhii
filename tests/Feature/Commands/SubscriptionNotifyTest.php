<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use App\Models\Post;
use App\Models\PostPublication;
use App\Models\Subscription;
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

    public function test_cannot_publish_post_when_it_is_already_published(): void
    {
        $post = Post::factory()->published()->create();

        PostPublication::query()->create(['post_id' => $post->id]);

        $this->artisan('subscriptions:notify')
            ->expectsOutput("Subscribers were already notified with post $post->title")
            ->assertExitCode(1);
    }

    public function test_2_subscribers_are_notified_when_with_new_post(): void
    {
        Post::factory()->published()->create();
        Subscription::factory()->count(2)->confirmed()->create();

        $this->artisan('subscriptions:notify')
             ->expectsOutput('2 subscribers were successfully notified')
             ->assertExitCode(0);

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
            ->expectsOutput('1 subscribers were successfully notified')
            ->assertExitCode(0);

        $this->assertDatabaseHas('post_publications', ['people_notified' => 1]);
        $this->assertSame(1, PostPublication::query()->count());
    }
}
