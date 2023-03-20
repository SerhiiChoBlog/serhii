<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class PostLikeTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testPostLikeHasRelationshipsWithPostAndVisitor(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();

        /** @var Visitor $visitor */
        $visitor = Visitor::factory()->create();

        /** @var PostLike $like */
        $like = PostLike::factory()->create([
            'post_id' => $post->id,
            'visitor_id' => $visitor->id,
        ]);

        $this->assertSame($post->id, $like->post->id);
        $this->assertSame($visitor->id, $like->visitor->id);
    }
}
