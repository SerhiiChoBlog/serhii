<?php

declare(strict_types=1);

namespace Tests\Feature\Recommendations;

use App\Models\Post;
use App\Models\Visitor;
use App\Recommendations\Filters\ViewedContentFilter;
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
        $posts = Post::factory()->count(5)->create();

        /** @var Visitor $visitor */
        $visitor = Visitor::factory()->create(['ip' => self::FAKE_IP_ADDRESS]);

        // Mock ip address in request
        $this->app['request']->server->set('REMOTE_ADDR', self::FAKE_IP_ADDRESS);

        $visitor->postViews()->create(['post_id' => $posts[0]?->id]);
        $visitor->postViews()->create(['post_id' => $posts[1]?->id]);

        $result = (new RecommendationHandler($posts, 3))
            ->useFilter(new ViewedContentFilter())
            ->get();

        $this->assertCount(3, $result);
        $this->assertSame($posts[2]?->id, $result[0]?->id);
        $this->assertSame($posts[3]?->id, $result[1]?->id);
        $this->assertSame($posts[4]?->id, $result[2]?->id);
    }
}
