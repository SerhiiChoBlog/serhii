<?php

declare(strict_types=1);

namespace Tests\Feature\CommentModifiers;

use App\CommentModifiers\ReplacePostUrlsModifier;
use App\Models\Post;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ReplacePostUrlsModifierTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testReplacesPostLinkWithHtmlLink(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();
        $post_url = route('posts.show', $post);

        $comment = "You need to read {$post_url} article!";
        $expect = "You need to read <a href=\"/posts/{$post->slug}\">{$post->title}</a> article!";

        $modifier = new ReplacePostUrlsModifier($comment);

        $this->assertSame($expect, $modifier->modify());
    }

    public function testReplacesMultiplePostLinks(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();
        $post_url = route('posts.show', $post);

        /** @var Post $post2 */
        $post2 = Post::factory()->create();
        $post2_url = route('posts.show', $post2);

        $comment = "You need to read {$post_url} and {$post2_url} articles!";
        $expect = "You need to read <a href=\"/posts/{$post->slug}\">{$post->title}</a> and <a href=\"/posts/{$post2->slug}\">{$post2->title}</a> articles!";

        $modifier = new ReplacePostUrlsModifier($comment);

        $this->assertSame($expect, $modifier->modify());
    }

    public function testDoesNotReplaceNonPostLinks(): void
    {
        $comment = 'You need to read https://google.com article!';
        $expect = 'You need to read https://google.com article!';

        $modifier = new ReplacePostUrlsModifier($comment);

        $this->assertSame($expect, $modifier->modify());
    }

    public function testReplacesPostLinksWhenPostUrlIsNearSomeWord(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();
        $post_url = route('posts.show', $post);

        $comment = "You need to read {$post_url}article!";
        $expect = "You need to read <a href=\"/posts/{$post->slug}\">{$post->title}</a>article!";

        $modifier = new ReplacePostUrlsModifier($comment);

        $this->assertSame($expect, $modifier->modify());
    }

    public function testModifierDoesntDoAnythingWhenNoLinksInComment(): void
    {
        $comment = 'You need to read article!';

        $modifier = new ReplacePostUrlsModifier($comment);

        $this->assertSame($comment, $modifier->modify());
    }
}
