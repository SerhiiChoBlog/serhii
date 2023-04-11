<?php

declare(strict_types=1);

namespace Tests\Feature\Recommendations;

use App\Models\Post;
use App\Models\Visitor;
use App\Recommendations\Filters\UnreadPostsFilter;
use App\Recommendations\RecommendationHandler;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class RecommendationHandlerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const FAKE_IP_ADDRESS = '64.233.160.0';

    public function testItCanFilterPostsByRemovingViewedPosts(): void
    {
        /** @var Collection<int, Post> $posts */
        $posts = Post::factory()->published()->count(5)->create();

        /** @var Visitor $visitor */
        $visitor = Visitor::factory()->create(['ip' => self::FAKE_IP_ADDRESS]);

        $this->fakeIpAddress();

        $viewed_posts = [$posts[0]?->id, $posts[1]?->id];
        $visitor->postViews()->create(['post_id' => $viewed_posts[0]]);
        $visitor->postViews()->create(['post_id' => $viewed_posts[1]]);

        $result = (new RecommendationHandler(3))
            ->useFilter(new UnreadPostsFilter())
            ->get();

        $this->assertCount(3, $result);

        $viewed_posts_missing = $result->every(function (Post $post) use ($viewed_posts) {
            return !in_array($post->id, $viewed_posts, true);
        });

        $this->assertTrue($viewed_posts_missing);
    }

    public function testItCanReturnRandomPostsIfNotEnoughPostsAreAvailable(): void
    {
        /** @var Collection<int, Post> $posts */
        $posts = Post::factory()->published()->count(7)->create();

        /** @var Visitor $visitor */
        $visitor = Visitor::factory()->create(['ip' => self::FAKE_IP_ADDRESS]);

        $this->fakeIpAddress();

        $viewed_posts = [$posts[2]?->id, $posts[3]?->id];
        $visitor->postViews()->create(['post_id' => $viewed_posts[0]]);
        $visitor->postViews()->create(['post_id' => $viewed_posts[1]]);

        $result = (new RecommendationHandler(5))
            ->useFilter(new UnreadPostsFilter())
            ->get();

        $this->assertCount(5, $result);

        $viewed_posts_missing = $result->every(function (Post $post) use ($viewed_posts) {
            return !in_array($post->id, $viewed_posts, true);
        });

        $this->assertTrue($viewed_posts_missing);
    }

    public function testItReturnsRandomPostsIfUserViewedEverySingleOne(): void
    {
        /** @var Collection<int, Post> $posts */
        $posts = Post::factory()->published()->count(3)->create();

        /** @var Visitor $visitor */
        $visitor = Visitor::factory()->create(['ip' => self::FAKE_IP_ADDRESS]);

        $this->fakeIpAddress();

        $viewed_posts = [$posts[0]?->id, $posts[1]?->id, $posts[2]?->id];
        $visitor->postViews()->create(['post_id' => $viewed_posts[0]]);
        $visitor->postViews()->create(['post_id' => $viewed_posts[1]]);
        $visitor->postViews()->create(['post_id' => $viewed_posts[2]]);

        $result = (new RecommendationHandler(3))
            ->useFilter(new UnreadPostsFilter())
            ->get();

        $this->assertCount(3, $result);

        $viewed_posts_present = $result->every(function (Post $post) use ($viewed_posts) {
            return in_array($post->id, $viewed_posts, true);
        });

        $this->assertTrue($viewed_posts_present);
    }

    private function fakeIpAddress(): void
    {
        $this->app['request']->server->set('REMOTE_ADDR', self::FAKE_IP_ADDRESS);
    }
}
