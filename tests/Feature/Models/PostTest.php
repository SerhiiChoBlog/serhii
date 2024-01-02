<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Keyword;
use App\Models\Post;
use App\Models\PostContentImage;
use App\Models\PostLike;
use App\Models\PostPublication;
use App\Models\Series;
use App\Models\Tag;
use App\Models\Video;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use LazilyRefreshDatabase;

    private Post $post;

    public function setUp(): void
    {
        parent::setUp();
        $this->post = Post::factory()->create();
    }

    public function testPostCanBeCreated(): void
    {
        $this->assertDatabaseCount('posts', 1);
    }

    public function testPostCanHaveSingleSeries(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();
        $series = Series::factory()->create();

        $post->series()->attach($series);

        $result = $post->series;

        $this->assertNotNull($result);
        $this->assertSame($series->id, $result[0]->id);
    }

    public function testPostHasTagsRelated(): void
    {
        /** @var Tag $tag */
        $tag = Tag::factory()->create();

        $this->post->tags()->attach($tag);

        $this->assertCount(1, $this->post->tags);
    }

    public function testPostHasImagesRelated(): void
    {
        PostContentImage::factory()->create([
            'post_id' => $this->post->id,
        ]);

        $this->assertCount(1, $this->post->images);
    }

    public function testPostHasCommentsRelated(): void
    {
        $user = $this->createUser();

        Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $this->post->id,
        ]);

        $this->assertCount(1, $this->post->comments);
    }

    public function testPostHasKeywordsRelated(): void
    {
        $keyword = Keyword::factory()->create();

        $this->post->keywords()->attach($keyword);

        $keywords = $this->post->keywords;

        $this->assertCount(1, $keywords);
        $this->assertInstanceOf(Keyword::class, $this->post->keywords->first());
    }

    public function testPostHasPostPublicationRelated(): void
    {
        PostPublication::factory()->create([
            'post_id' => $this->post->id,
        ]);

        $this->assertNotNull($this->post->postPublication);
    }

    public function testPostHasVideoRelated(): void
    {
        Video::factory()->create([
            'post_id' => $this->post->id,
        ]);

        $this->assertNotNull($this->post->video);
    }

    public function testPostHasPrettyUpdatedAtField(): void
    {
        $this->assertNotNull($this->post->pretty_updated_at);
    }

    public function testPostCanHaveLikes(): void
    {
        $user = $this->createUser();

        PostLike::factory()->create([
            'user_id' => $user->id,
            'post_id' => $this->post->id,
        ]);

        $this->assertCount(1, $this->post->postLikes);
    }

    public function testMainTagIsAlwaysFirst(): void
    {
        $tag1 = Tag::factory()->create();
        $main_tag = Tag::factory()->create();
        $tag2 = Tag::factory()->create();

        $this->post->tags()->attach([
            $tag1->id => ['is_main' => false],
            $main_tag->id => ['is_main' => true],
            $tag2->id => ['is_main' => false],
        ]);

        $this->assertSame($main_tag->id, $this->post->tags->first()->id);
    }
}
