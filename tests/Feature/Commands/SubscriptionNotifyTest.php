<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use App\Models\Post;
use App\Models\PostPublication;
use App\Models\Subscription;
use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SubscriptionNotifyTest extends TestCase
{
    use DatabaseMigrations;

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
        Subscription::factory()->count(2)->create();

        $this->artisan('subscriptions:notify')
             ->expectsOutput('2 subscribers were successfully notified')
             ->assertExitCode(0);
    }

    public function test_exception_is_thrown_when_there_are_no_posts(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('There are no posts in database');

        $this->artisan('subscriptions:notify');
    }

    public function test_1_subscriber_is_notified_when_with_new_post(): void
    {
        $post = Post::factory()->published()->create();
        $sub = Subscription::factory()->create();

        $this->artisan('subscriptions:notify')
            ->expectsOutput('1 subscribers were successfully notified')
            ->assertExitCode(0);
    }
}
