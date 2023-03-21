<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class PostLikeTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testPostLikeHasRelationshipsWithPostAndUser(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();

        $user = $this->createUser();

        /** @var PostLike $like */
        $like = PostLike::factory()->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        $this->assertSame($post->id, $like->post->id);
        $this->assertSame($user->id, $like->user->id);
    }
}
