<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\PostContentImage;
use App\Models\PostPublication;
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

    public function testPostHasTagsAssociated(): void
    {
        /** @var Tag $tag */
        $tag = Tag::factory()->create();

        $this->post->tags()->attach([$tag->id]);

        $this->assertCount(1, $this->post->tags);
    }

    public function testPostHasImagesAssociated(): void
    {
        PostContentImage::factory()->create([
            'post_id' => $this->post->id,
        ]);

        $this->assertCount(1, $this->post->images);
    }

    public function testPostHasCommentsAssociated(): void
    {
        $user = $this->createUser();

        Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $this->post->id,
        ]);

        $this->assertCount(1, $this->post->comments);
    }

    public function testPostHasPostPublicationAssociated(): void
    {
        PostPublication::factory()->create([
            'post_id' => $this->post->id,
        ]);

        $this->assertNotNull($this->post->postPublication);
    }

    public function testPostHasVideoAssociated(): void
    {
        Video::factory()->create([
            'post_id' => $this->post->id,
        ]);

        $this->assertNotNull($this->post->video);
    }

    public function testPostHasPrettyCreatedAtField(): void
    {
        $this->assertNotNull($this->post->pretty_created_at);
    }

    public function testPostHasTagAssociated(): void
    {
        /** @var Tag $tag */
        $tag = Tag::factory()->create();
        $this->post->update(['tag_id' => $tag->id]);

        $this->assertNotNull($this->post->tag);
        $this->assertSame($tag->name, $this->post->tag->name);
    }

    public function testPostHasTagAssociatedThatCanBeNull(): void
    {
        $this->assertNull($this->post->tag);
    }
}
