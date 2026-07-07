<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Keyword;
use App\Models\Post;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class KeywordTest extends TestCase
{
    use LazilyRefreshDatabase;

    private Keyword $keyword;

    public function setUp(): void
    {
        parent::setUp();
        $this->keyword = Keyword::factory()->create();
    }

    public function testWeCanCreateKeyword(): void
    {
        $this->assertDatabaseHas('keywords', [
            'id' => $this->keyword->id,
            'name' => $this->keyword->name,
        ]);
    }

    public function testRelatedToPosts(): void
    {
        $post = Post::factory()->create();

        $this->keyword->posts()->attach($post);

        $related_post = $this->keyword->posts->first();

        $this->assertInstanceOf(Post::class, $related_post);
        $this->assertSame($post->id, $related_post->id);
    }
}
