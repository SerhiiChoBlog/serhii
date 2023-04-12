<?php

declare(strict_types=1);

namespace Tests\Feature\Recommendations;

use App\Models\Post;
use App\Models\Series;
use App\Models\Tag;
use App\Models\Visitor;
use App\Recommendations\Filters\ExclusionFilter;
use App\Recommendations\Filters\PostSeriesFilter;
use App\Recommendations\Filters\PostTagsFilter;
use App\Recommendations\Filters\ViewedPostsFilter;
use App\Recommendations\RecommendationHandler;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class RecommendationHandlerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testItCanFilterPostsByRemovingViewedPosts(): void
    {
        $post1 = Post::factory()->published()->create();
        $post2 = Post::factory()->published()->create();

        Post::factory()->published()->count(3)->create();

        /** @var Visitor $visitor */
        $visitor = Visitor::factory()->create();

        $this->fakeIpAddress($visitor->ip);

        $visitor->postViews()->create(['post_id' => $post1->id]);
        $visitor->postViews()->create(['post_id' => $post2->id]);

        $result = (new RecommendationHandler(3))
            ->useFilter(new ViewedPostsFilter())
            ->get();

        $this->assertCount(3, $result);
        $this->assertFalse($result->contains(fn (Post $p) => $p->id === $post1->id), 'Viewed post 1 is not missing');
        $this->assertFalse($result->contains(fn (Post $p) => $p->id === $post2->id), 'Viewed post 2 is not missing');
    }

    public function testItCanReturnRandomPostsIfNotEnoughPostsAreAvailable(): void
    {
        $post1 = Post::factory()->published()->create();
        $post2 = Post::factory()->published()->create();

        Post::factory()->published()->count(5)->create();

        /** @var Visitor $visitor */
        $visitor = Visitor::factory()->create();

        $this->fakeIpAddress($visitor->ip);

        $visitor->postViews()->create(['post_id' => $post1->id]);
        $visitor->postViews()->create(['post_id' => $post2->id]);

        $result = (new RecommendationHandler(5))
            ->useFilter(new ViewedPostsFilter())
            ->get();

        $this->assertCount(5, $result);

        $this->assertFalse($result->contains(fn (Post $p) => $p->id === $post1->id), 'Viewed post 1 is not missing');
        $this->assertFalse($result->contains(fn (Post $p) => $p->id === $post2->id), 'Viewed post 2 is not missing');
    }

    public function testItReturnsRandomPostsIfUserViewedEverySingleOne(): void
    {
        $post1 = Post::factory()->published()->create();
        $post2 = Post::factory()->published()->create();
        $post3 = Post::factory()->published()->create();

        /** @var Visitor $visitor */
        $visitor = Visitor::factory()->create();

        $this->fakeIpAddress($visitor->ip);

        $visitor->postViews()->create(['post_id' => $post1->id]);
        $visitor->postViews()->create(['post_id' => $post2->id]);
        $visitor->postViews()->create(['post_id' => $post3->id]);

        $result = (new RecommendationHandler(3))
            ->useFilter(new ViewedPostsFilter())
            ->get();

        $this->assertCount(3, $result);
        $this->assertTrue($result->contains(fn (Post $p) => $p->id === $post1->id), 'Viewed post 1 is missing');
        $this->assertTrue($result->contains(fn (Post $p) => $p->id === $post2->id), 'Viewed post 2 is missing');
        $this->assertTrue($result->contains(fn (Post $p) => $p->id === $post3->id), 'Viewed post 3 is missing');
    }

    public function testItReturnsPostsFromSeriesWithCorrectFilter(): void
    {
        /** @var Series $series */
        $series = Series::factory()->create();

        $post1 = Post::factory()->published()->create();
        $post2 = Post::factory()->published()->create();
        $post3 = Post::factory()->published()->create();

        $series->posts()->attach([
            $post1->id => ['part' => 1],
            $post2->id => ['part' => 2],
        ]);

        $result = (new RecommendationHandler(2))
            ->useFilter(new PostSeriesFilter($post1))
            ->get();

        $this->assertCount(2, $result);
        $this->assertTrue($result->contains(fn (Post $p) => $p->id === $post3->id));
    }

    public function testItCanFilterPostsByMainTag(): void
    {
        $post1 = Post::factory()->published()->create();
        $post2 = Post::factory()->published()->create();
        $post3 = Post::factory()->published()->create();
        $post4 = Post::factory()->published()->create();
        $post5 = Post::factory()->published()->create();

        $tag1 = Tag::factory()->create();
        $tag2 = Tag::factory()->create();
        $tag3 = Tag::factory()->create();

        $post1->tags()->attach([$tag1->id => ['is_main' => true], $tag2->id]);
        $post2->tags()->attach([$tag1->id, $tag2->id]);
        $post3->tags()->attach([$tag1->id]);
        $post4->tags()->attach([$tag3->id]);
        $post5->tags()->attach([$tag3->id]);

        $result = (new RecommendationHandler(3))
            ->useFilter(new PostTagsFilter($post1))
            ->get();

        $this->assertCount(3, $result);
        $this->assertTrue($result->contains(fn (Post $p) => $p->id === $post2->id), 'Post 2 is missing');
        $this->assertTrue($result->contains(fn (Post $p) => $p->id === $post3->id), 'Post 3 is missing');
    }

    public function testItIsNotReturningDuplicatePosts(): void
    {
        $post1 = Post::factory()->published()->create();
        $post2 = Post::factory()->published()->create();
        $post3 = Post::factory()->published()->create();
        $post4 = Post::factory()->published()->create();
        $post5 = Post::factory()->published()->create();
        $post6 = Post::factory()->published()->create();

        $tag1 = Tag::factory()->create();
        $tag2 = Tag::factory()->create();
        $tag3 = Tag::factory()->create();
        $tag4 = Tag::factory()->create();

        $post1->tags()->attach([$tag1->id, $tag2->id, $tag3->id]);
        $post2->tags()->attach([$tag1->id, $tag2->id]);
        $post3->tags()->attach([$tag1->id, $tag3->id]);
        $post4->tags()->attach([$tag3->id]);
        $post5->tags()->attach([$tag4->id]);
        $post6->tags()->attach([$tag4->id]);

        $result = (new RecommendationHandler(3))
            ->useFilter(new PostTagsFilter($post1))
            ->get();

        $this->assertCount(3, $result);
        $this->assertTrue($result->duplicates()->isEmpty(), 'There are duplicates in the result');
        $this->assertTrue($result->contains(fn (Post $p) => $p->id === $post2->id), 'Post 2 is missing');
        $this->assertTrue($result->contains(fn (Post $p) => $p->id === $post3->id), 'Post 3 is missing');
        $this->assertTrue($result->contains(fn (Post $p) => $p->id === $post4->id), 'Post 4 is missing');
    }

    public function testSeriesFilterWorksTogetherWithTagsAndViewedPostsFilter(): void
    {
        /** @var Series $series */
        $series = Series::factory()->create();

        /** @var Visitor $visitor */
        $visitor = Visitor::factory()->create();

        $this->fakeIpAddress($visitor->ip);

        $post1 = Post::factory()->published()->create();
        $post2 = Post::factory()->published()->create();

        Post::factory()->published()->count(3)->create();

        $post6 = Post::factory()->published()->create();
        $post7 = Post::factory()->published()->create();

        $visitor->postViews()->create(['post_id' => $post7->id]);

        $tag = Tag::factory()->create();

        $post1->tags()->attach([$tag->id]);
        $post6->tags()->attach([$tag->id]);
        $post7->tags()->attach([$tag->id]);

        $series->posts()->attach([
            $post1->id => ['part' => 1],
            $post2->id => ['part' => 2],
        ]);

        $result = (new RecommendationHandler(3))
            ->useFilter(new PostSeriesFilter($post1))
            ->useFilter(new PostTagsFilter($post1))
            ->useFilter(new ViewedPostsFilter())
            ->get();

        $this->assertCount(3, $result);
        $this->assertTrue($result->contains(fn (Post $p) => $p->id === $post2->id), 'Does not contain post 2 from series');
        $this->assertTrue($result->contains(fn (Post $p) => $p->id === $post6->id), 'Does not contain post 6 with same tag');
        $this->assertFalse($result->contains(fn (Post $p) => $p->id === $post7->id), 'Result contains post 7, but it was already viewed');
    }

    public function testExclusionFilterExcludesGivenPostsFromResult(): void
    {
        $post1 = Post::factory()->published()->create();
        $post2 = Post::factory()->published()->create();

        Post::factory()->published()->count(2)->create();

        $exclude_ids = collect([$post1->id, $post2->id]);

        $result = (new RecommendationHandler(2))
            ->useFilter(new ExclusionFilter($exclude_ids))
            ->get();

        $this->assertCount(2, $result);
        $this->assertFalse($result->contains(fn (Post $p) => $p->id === $post1->id), 'Result contains post 1, but it was excluded');
        $this->assertFalse($result->contains(fn (Post $p) => $p->id === $post2->id), 'Result contains post 2, but it was excluded');
    }

    private function fakeIpAddress(string $ip): void
    {
        $this->app['request']->server->set('REMOTE_ADDR', $ip);
    }
}
