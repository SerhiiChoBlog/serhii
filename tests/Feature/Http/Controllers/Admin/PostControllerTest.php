<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Series;
use App\Models\Tag;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Intervention\Image\Facades\Image;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const INDEX_URI = '/admin/ajax/posts';
    private const UPDATE_URI = '/admin/ajax/posts/1';
    private const STORE_URI = '/admin/ajax/posts';
    private const EDIT_URI = '/admin/ajax/posts/1/edit';
    private const DELETE_URI = '/admin/ajax/posts/1';

    public function testUserCannotCreatePost(): void
    {
        $user = $this->createUser();

        $params = ['title' => 'This is the post title for post'];

        $this->actingAs($user, 'user')
            ->postJson(self::STORE_URI, $params)
            ->assertUnauthorized();

        $this->assertDatabaseEmpty('posts');
    }

    public function testAdminCanCreatePost(): void
    {
        $admin = $this->createAdmin();

        $params = ['title' => 'This is the post title for post'];

        $this->actingAs($admin, 'admin')
            ->postJson(self::STORE_URI, $params)
            ->assertOk();

        $this->assertDatabaseHas('posts', $params);
    }

    public function testCanCreatePostWithSeriesAttached(): void
    {
        $admin = $this->createAdmin();
        $series = Series::factory()->create();

        $this->withoutExceptionHandling();
        $params = [
            'title' => 'This is the post title for post',
            'series' => $series->id,
        ];

        $this->actingAs($admin, 'admin')
            ->postJson(self::STORE_URI, $params)
            ->assertOk();

        $this->assertDatabaseHas('post_series', [
            'post_id' => 1,
            'series_id' => $series->id,
            'part' => 1,
        ]);
    }

    public function testCanCreatePostWithSeriesAttachedWithCorrectPart(): void
    {
        /** @var Collection<int, Post> $posts */
        $posts = Post::factory(2)->create();

        $admin = $this->createAdmin();
        $series = Series::factory()->create();

        $series->posts()->attach([
            $posts->first()?->id => ['part' => 1],
            $posts->last()?->id => ['part' => 2],
        ]);

        $params = [
            'title' => 'This is the post title for post',
            'series' => $series->id,
        ];

        $this->actingAs($admin, 'admin')
            ->postJson(self::STORE_URI, $params)
            ->assertOk();

        $this->assertDatabaseHas('post_series', [
            'post_id' => 3,
            'series_id' => $series->id,
            'part' => 3,
        ]);
    }

    public function testAdminCanUpdate(): void
    {
        $admin = $this->createAdmin();
        $post = Post::factory()->create();

        $params = [
            'title' => $post->title,
            'intro' => 'This is a new intro for a post',
            'is_published' => false,
            'content' => 'This is some new content',
            'slug' => $post->slug,
        ];

        $this->actingAs($admin, 'admin')
            ->putJson(self::UPDATE_URI, $params)
            ->assertOk();

        $this->assertDatabaseHas('posts', $params);
    }

    public function testProvidingImageFileWillSaveThemToStorage(): void
    {
        Image::shouldReceive('make', 'fit', 'save')
            ->times(3)
            ->andReturnSelf();

        $admin = $this->createAdmin();
        $post = Post::factory()->create();

        $params = [
            'title' => $post->title,
            'intro' => 'This is a new intro for a post',
            'is_published' => false,
            'content' => 'This is some new content',
            'slug' => $post->slug,
            'image' => UploadedFile::fake()->image('some-image.jpg'),
        ];

        $this->actingAs($admin, 'admin')
            ->putJson(self::UPDATE_URI, $params)
            ->assertOk();

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'image_sm' => "storage/posts/sm/{$post->slug}.jpg",
            'image_lg' => "storage/posts/lg/{$post->slug}.jpg",
            'image_xs' => "storage/posts/xs/{$post->slug}.jpg",
        ]);
    }

    public function testNotProvidingImageFileWillKeepPostImagesUntouched(): void
    {
        Image::shouldReceive('make', 'fit', 'save')->times(0);

        $admin = $this->createAdmin();

        $images = [
            'image_xs' => 'storage/posts/xs/some-image.jpg',
            'image_sm' => 'storage/posts/sm/some-image.jpg',
            'image_lg' => 'storage/posts/lg/some-image.jpg',
        ];

        $post = Post::factory()->create($images);

        $params = [
            'title' => $post->title,
            'intro' => 'This is a new intro for a new post',
            'is_published' => false,
            'content' => 'This is some nice new content',
            'slug' => $post->slug,
        ];

        $this->actingAs($admin, 'admin')
            ->putJson(self::UPDATE_URI, $params)
            ->assertOk();

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'image_sm' => 'storage/posts/sm/some-image.jpg',
            'image_lg' => 'storage/posts/lg/some-image.jpg',
            'image_xs' => 'storage/posts/xs/some-image.jpg',
        ]);
    }

    public function testItAddsNotesToContent(): void
    {
        $admin = $this->createAdmin();
        $post = Post::factory()->create();

        $params = [
            'title' => $post->title,
            'intro' => $post->intro,
            'is_published' => false,
            'content' => <<<TEXT
            <p>This is some text here</p>
            <p>Note. Be careful mate!</p>
            TEXT,
            'slug' => $post->slug,
        ];

        $this->actingAs($admin, 'admin')
            ->putJson(self::UPDATE_URI, $params)
            ->assertOk();

        $expect = <<<TEXT
        <p>This is some text here</p>
        <p class="note"><span class="hidden" aria-label="Note">Note. </span>Be careful mate!</p>
        TEXT;

        $this->assertSame($expect, $post->fresh()?->content);
    }

    public function testItAddsTipsToContent(): void
    {
        $admin = $this->createAdmin();
        $post = Post::factory()->create();

        $params = [
            'title' => $post->title,
            'intro' => $post->intro,
            'is_published' => false,
            'content' => <<<TEXT
            <p>This is some text here</p>
            <p>Tip. Be careful mate!</p>
            TEXT,
            'slug' => $post->slug,
        ];

        $this->actingAs($admin, 'admin')
            ->putJson(self::UPDATE_URI, $params)
            ->assertOk();

        $expect = <<<TEXT
        <p>This is some text here</p>
        <p class="tip"><span class="hidden" aria-label="Tip">Tip. </span>Be careful mate!</p>
        TEXT;

        $this->assertSame($expect, $post->fresh()?->content);
    }

    public function testItDoesntAddTipToTheNextElement(): void
    {
        $admin = $this->createAdmin();
        $post = Post::factory()->create();

        $params = [
            'title' => $post->title,
            'intro' => $post->intro,
            'is_published' => false,
            'content' => <<<TEXT
            <p>This is some text here</p>
            <p>Tip. Be careful mate!</p>
            <p>This is some next paragraph</p>
            TEXT,
            'slug' => $post->slug,
        ];

        $this->actingAs($admin, 'admin')
            ->putJson(self::UPDATE_URI, $params)
            ->assertOk();

        $expect = <<<TEXT
        <p>This is some text here</p>
        <p class="tip"><span class="hidden" aria-label="Tip">Tip. </span>Be careful mate!</p>
        <p>This is some next paragraph</p>
        TEXT;

        $this->assertSame($expect, $post->fresh()?->content);
    }

    public function testItAddsWarningsToContent(): void
    {
        $admin = $this->createAdmin();
        $post = Post::factory()->create();

        $params = [
            'title' => $post->title,
            'intro' => $post->intro,
            'is_published' => false,
            'content' => <<<TEXT
            <p>This is some text here</p>
            <p>Warning. Be careful man!</p>
            TEXT,
            'slug' => $post->slug,
        ];

        $this->actingAs($admin, 'admin')
            ->putJson(self::UPDATE_URI, $params)
            ->assertOk();

        $expect = <<<TEXT
        <p>This is some text here</p>
        <p class="note"><span class="hidden" aria-label="Warning">Warning. </span>Be careful man!</p>
        TEXT;

        $this->assertSame($expect, $post->fresh()?->content);
    }

    public function testItChangesImageToLazyLoading(): void
    {
        $admin = $this->createAdmin();
        $post = Post::factory()->create();

        $params = [
            'title' => $post->title,
            'intro' => $post->intro,
            'is_published' => false,
            'content' => <<<TEXT
            <h2>Successful people</h2>
            <img alt="Anna Cho" src="storage/people/anna-cho.jpg" />
            <img src="storage/people/serhii-cho.jpg" alt="Serhii Cho" />
            TEXT,
            'slug' => $post->slug,
        ];

        $this->actingAs($admin, 'admin')
            ->putJson(self::UPDATE_URI, $params)
            ->assertOk();

        $expect = <<<TEXT
        <h2>Successful people</h2>
        <img alt="Anna Cho" data-src="storage/people/anna-cho.jpg" />
        <img data-src="storage/people/serhii-cho.jpg" alt="Serhii Cho" />
        TEXT;

        $this->assertSame($expect, $post->fresh()?->content);
    }

    public function testEditPostReturnsPostWithoutLazyImages(): void
    {
        $admin = $this->createAdmin();

        Post::factory()->create([
            'content' => <<<'HTML'
            <h2>Successful people</h2>
            <img alt="Anna Cho" src="storage/people/anna-cho.jpg" />
            <img src="storage/people/serhii-cho.jpg" alt="Serhii Cho" />
            HTML,
        ]);

        $resp = $this->actingAs($admin, 'admin')
            ->getJson(self::EDIT_URI);

        $expect_content = <<<TEXT
        <h2>Successful people</h2>
        <img alt="Anna Cho" src="storage/people/anna-cho.jpg" />
        <img src="storage/people/serhii-cho.jpg" alt="Serhii Cho" />
        TEXT;

        $this->assertSame($expect_content, $resp->json('content'));
    }

    public function testUserCannotEditPost(): void
    {
        $user = $this->createAdmin();

        Post::factory()->create();

        $this->actingAs($user, 'user')
            ->getJson(self::EDIT_URI)
            ->assertUnauthorized();
    }

    public function testUserCannotUpdatePost(): void
    {
        $user = $this->createAdmin();
        $post = Post::factory()->create();

        $params = [
            'title' => $post->title,
            'intro' => $post->intro,
            'is_published' => false,
            'content' => 'This is some content here',
            'slug' => $post->slug,
        ];

        $this->actingAs($user, 'user')
            ->putJson(self::UPDATE_URI, $params)
            ->assertUnauthorized();
    }

    public function testAdminCanDeletePost(): void
    {
        $admin = $this->createAdmin();
        $post = Post::factory()->published()->create();

        $this->actingAs($admin, 'admin')
            ->deleteJson(self::DELETE_URI)
            ->assertOk();

        $this->assertDatabaseEmpty('posts');
    }

    public function testUserCannotDeletePost(): void
    {
        $user = $this->createAdmin();
        $post = Post::factory()->published()->create();

        $this->actingAs($user, 'user')
            ->deleteJson(self::DELETE_URI)
            ->assertUnauthorized();

        $this->assertDatabaseCount('posts', 1);
    }

    public function testAdminCanGetPosts(): void
    {
        $admin = $this->createAdmin();
        Post::factory(2)->published()->create();

        $resp = $this->actingAs($admin, 'admin')
            ->getJson(self::INDEX_URI);

        $json = $resp->json();

        $this->assertIsArray($json['data']);
        $this->assertCount(2, $json['data']);
    }

    public function testYouCanAddTagsToPost(): void
    {
        /** @var Tag $tag */
        $tag = Tag::factory()->create();

        /** @var Post $post */
        $post = Post::factory()->create();

        $admin = $this->createAdmin();

        $params = [
            'title' => $post->title,
            'intro' => $post->intro,
            'is_published' => false,
            'content' => $post->content,
            'slug' => $post->slug,
            'tags' => "[{$tag->id}]",
        ];

        $this->actingAs($admin, 'admin')
            ->putJson(self::UPDATE_URI, $params);

        $this->assertDatabaseHas('post_tag', [
            'tag_id' => $tag->id,
            'post_id' => $post->id,
            'is_main' => false,
        ]);
    }


    public function testWhenYouPassTagIdThenThisTagBecomesMain(): void
    {
        /** @var Collection<int, Tag> $tags */
        $tags = Tag::factory(3)->create();

        /** @var Post $post */
        $post = Post::factory()->create();

        $admin = $this->createAdmin();

        $params = [
            'title' => $post->title,
            'intro' => $post->intro,
            'is_published' => false,
            'content' => $post->content,
            'slug' => $post->slug,
            'tags' => "[{$tags[0]->id}, {$tags[1]->id}, {$tags[2]->id}]",
            'tag_id' => $tags[1]->id,
        ];

        $this->actingAs($admin, 'admin')
            ->putJson(self::UPDATE_URI, $params);

        $this->assertDatabaseHas('post_tag', [
            'tag_id' => $tags[0]->id,
            'is_main' => false,
        ]);

        $this->assertDatabaseHas('post_tag', [
            'tag_id' => $tags[1]->id,
            'is_main' => true,
        ]);

        $this->assertDatabaseHas('post_tag', [
            'tag_id' => $tags[2]->id,
            'is_main' => false,
        ]);
    }
}
