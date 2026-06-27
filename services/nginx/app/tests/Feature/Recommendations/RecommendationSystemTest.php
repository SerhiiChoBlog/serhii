<?php

declare(strict_types=1);

namespace Tests\Feature\Recommendations;

use App\Models\Post;
use App\Models\Series;
use App\Models\Tag;
use App\Recommendations\Filters\ExclusionFilter;
use App\Recommendations\Filters\LikedPostsFilter;
use App\Recommendations\Filters\PostSeriesFilter;
use App\Recommendations\Filters\PostTagsFilter;
use App\Recommendations\RecommendationSystem;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class RecommendationSystemTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testItCanFilterPostsByRemovingLikedPosts(): void
    {
        $post1 = Post::factory()->published()->create();
        $post2 = Post::factory()->published()->create();

        Post::factory(3)->published()->create();

        $user = $this->createUser();

        $user->likePost($post1->id);
        $user->likePost($post2->id);

        $this->actingAs($user);

        $result = (new RecommendationSystem(3))
            ->pipe(new LikedPostsFilter())
            ->get();

        $this->assertCount(3, $result, 'There must be 3 posts in total');
        $this->assertFalse($result->contains(fn (Post $p) => $p->id === $post1->id), 'Viewed post 1 is not missing');
        $this->assertFalse($result->contains(fn (Post $p) => $p->id === $post2->id), 'Viewed post 2 is not missing');
    }

    public function testItReturnsPostsLessThanNeededWhenThereIsNotEnoughPosts(): void
    {
        $post1 = Post::factory()->published()->create();
        $post2 = Post::factory()->published()->create();
        Post::factory()->published()->create();

        $user = $this->createUser();

        $user->likePost($post1->id);
        $user->likePost($post2->id);

        $this->actingAs($user);

        $result = (new RecommendationSystem(5))
            ->pipe(new LikedPostsFilter())
            ->get();

        $this->assertCount(3, $result, 'There must be 3 posts in total');
    }

    public function testItCanReturnRandomPostsIfNotEnoughPostsAreAvailable(): void
    {
        $post1 = Post::factory()->published()->create();
        $post2 = Post::factory()->published()->create();

        Post::factory(5)->published()->create();

        $user = $this->createUser();

        $user->likePost($post1->id);
        $user->likePost($post2->id);

        $this->actingAs($user);

        $result = (new RecommendationSystem(5))
            ->pipe(new LikedPostsFilter())
            ->get();

        $this->assertCount(5, $result, 'There must be 5 posts in total');
        $this->assertFalse($result->contains(fn (Post $p) => $p->id === $post1->id), 'Viewed post 1 is not missing');
        $this->assertFalse($result->contains(fn (Post $p) => $p->id === $post2->id), 'Viewed post 2 is not missing');
    }

    public function testItReturnsRandomPostsIfUserLikedEverySingleOne(): void
    {
        $post1 = Post::factory()->published()->create();
        $post2 = Post::factory()->published()->create();
        $post3 = Post::factory()->published()->create();

        $user = $this->createUser();

        $user->likePost($post1->id);
        $user->likePost($post2->id);
        $user->likePost($post3->id);

        $this->actingAs($user);

        $result = (new RecommendationSystem(3))
            ->pipe(new LikedPostsFilter())
            ->get();

        $this->assertCount(3, $result, 'There must be 3 posts in total');
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

        Post::factory(2)->published()->create();

        $series->posts()->attach([
            $post1->id => ['part' => 1],
            $post2->id => ['part' => 2],
        ]);

        $result = (new RecommendationSystem(2))
            ->pipe(new PostSeriesFilter($post1))
            ->get();

        $this->assertCount(2, $result, 'There must be 2 posts in total');
        $this->assertFalse($result->contains(fn (Post $p) => $p->id === $post1->id), 'Main series post 1 is not excluded');
        $this->assertTrue($result->contains(fn (Post $p) => $p->id === $post2->id), 'Post 2 from series is missing');
    }

    public function testItCanFilterPostsByTags(): void
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

        $result = (new RecommendationSystem(3))
            ->pipe(new PostTagsFilter($post1))
            ->get();

        $this->assertCount(3, $result, 'There must be 3 posts in total');
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

        $result = (new RecommendationSystem(3))
            ->pipe(new PostTagsFilter($post1))
            ->get();

        $this->assertCount(3, $result, 'There must be 3 posts in total');
        $this->assertTrue($result->duplicates()->isEmpty(), 'There are duplicates in the result');
        $this->assertTrue($result->contains(fn (Post $p) => $p->id === $post2->id), 'Post 2 is missing');
        $this->assertTrue($result->contains(fn (Post $p) => $p->id === $post3->id), 'Post 3 is missing');
        $this->assertTrue($result->contains(fn (Post $p) => $p->id === $post4->id), 'Post 4 is missing');
    }

    public function testSeriesFilterWorksTogetherWithTagsAndLikedPostsFilter(): void
    {
        /** @var Series $series */
        $series = Series::factory()->create();

        $user = $this->createUser();

        $this->actingAs($user);

        $post1 = Post::factory()->published()->create();
        $post2 = Post::factory()->published()->create();

        Post::factory(3)->published()->create();

        $post6 = Post::factory()->published()->create();
        $post7 = Post::factory()->published()->create();

        $user->likePost($post7->id);

        $tag = Tag::factory()->create();

        $post1->tags()->attach([$tag->id]);
        $post6->tags()->attach([$tag->id]);
        $post7->tags()->attach([$tag->id]);

        $series->posts()->attach([
            $post1->id => ['part' => 1],
            $post2->id => ['part' => 2],
        ]);

        $result = (new RecommendationSystem(3))
            ->pipe(new LikedPostsFilter())
            ->pipe(new PostSeriesFilter($post1))
            ->pipe(new PostTagsFilter($post1))
            ->get();

        $this->assertCount(3, $result, 'There must be 3 posts in total');
        $this->assertTrue($result->contains(fn (Post $p) => $p->id === $post2->id), 'Does not contain post 2 from the same series');
        $this->assertTrue($result->contains(fn (Post $p) => $p->id === $post6->id), 'Does not contain post 6 with the same tag');
        $this->assertFalse($result->contains(fn (Post $p) => $p->id === $post7->id), 'Result contains post 7, but it was liked by user and should be excluded');
    }

    public function testExclusionFilterExcludesGivenPostsFromResult(): void
    {
        $post1 = Post::factory()->published()->create();
        $post2 = Post::factory()->published()->create();

        Post::factory(2)->published()->create();

        $exclude_ids = collect([$post1->id, $post2->id]);

        $result = (new RecommendationSystem(2))
            ->pipe(new ExclusionFilter($exclude_ids))
            ->get();

        $this->assertCount(2, $result, 'There must be 2 posts in total');
        $this->assertFalse($result->contains(fn (Post $p) => $p->id === $post1->id), 'Result contains post 1, but it was excluded');
        $this->assertFalse($result->contains(fn (Post $p) => $p->id === $post2->id), 'Result contains post 2, but it was excluded');
    }
}
