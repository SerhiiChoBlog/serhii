<?php

declare(strict_types=1);

namespace Tests\Feature\CommentModifiers;

use App\CommentModifiers\ReplaceLinksModifier;
use App\Models\Post;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ReplaceLinksModifierTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testReplacesPostLinkWithHtmlLink(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();
        $post_url = route('posts.show', $post);

        $comment = "You need to read {$post_url} article!";
        $expect = "You need to read <a href=\"/posts/{$post->slug}\">{$post->title}</a> article!";

        $modifier = new ReplaceLinksModifier($comment);

        $this->assertSame($expect, $modifier->modify());
    }
}
