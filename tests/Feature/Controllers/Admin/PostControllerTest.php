<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Admin;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const UPDATE_POST_URI = '/admin/ajax/posts/1';
    private const CREATE_POST_URI = '/admin/ajax/posts';
    private const EDIT_POST_URI = '/admin/ajax/posts/1/edit';

    public function testUserCannotCreatePost(): void
    {
        $user = User::factory()->create();

        $params = ['title' => 'This is the post title for post'];

        $this->actingAs($user, 'user')
            ->json('post', self::CREATE_POST_URI, $params)
            ->assertUnauthorized();

        $this->assertDatabaseEmpty('posts');
    }

    public function testAdminCanCreatePost(): void
    {
        $admin = $this->createAdmin();

        $params = ['title' => 'This is the post title for post'];

        $this->actingAs($admin, 'admin')
            ->json('post', self::CREATE_POST_URI, $params)
            ->assertOk();

        $this->assertDatabaseHas('posts', $params);
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
            ->json('put', self::UPDATE_POST_URI, $params)
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
            'image' => UploadedFile::fake()->image($img_name = 'some-image.jpg'),
        ];

        $this->actingAs($admin, 'admin')
            ->json('put', self::UPDATE_POST_URI, $params)
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
            ->json('put', self::UPDATE_POST_URI, $params)
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
            ->json('put', self::UPDATE_POST_URI, $params)
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
            ->json('put', self::UPDATE_POST_URI, $params)
            ->assertOk();

        $expect = <<<TEXT
        <p>This is some text here</p>
        <p class="tip"><span class="hidden" aria-label="Tip">Tip. </span>Be careful mate!</p>
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
            ->json('put', self::UPDATE_POST_URI, $params)
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
            <img alt="Andrew Tate" src="storage/people/andrew-tate.jpg" />
            <img src="storage/people/tristan-tate.jpg" alt="Tristan Tate" />
            TEXT,
            'slug' => $post->slug,
        ];

        $this->actingAs($admin, 'admin')
            ->json('put', self::UPDATE_POST_URI, $params)
            ->assertOk();

        $expect = <<<TEXT
        <h2>Successful people</h2>
        <img alt="Andrew Tate" data-src="storage/people/andrew-tate.jpg" />
        <img data-src="storage/people/tristan-tate.jpg" alt="Tristan Tate" />
        TEXT;

        $this->assertSame($expect, $post->fresh()?->content);
    }

    public function testEditPostReturnsPostWithoutLazyImages(): void
    {
        $admin = $this->createAdmin();

        Post::factory()->create([
            'content' => <<<HTML
            <h2>Successful people</h2>
            <img alt="Andrew Tate" src="storage/people/andrew-tate.jpg" />
            <img src="storage/people/tristan-tate.jpg" alt="Tristan Tate" />
            HTML,
        ]);

        $resp = $this->actingAs($admin, 'admin')
            ->json('get', self::EDIT_POST_URI);

        $expect_content = <<<TEXT
        <h2>Successful people</h2>
        <img alt="Andrew Tate" src="storage/people/andrew-tate.jpg" />
        <img src="storage/people/tristan-tate.jpg" alt="Tristan Tate" />
        TEXT;

        $this->assertSame($expect_content, $resp->json('content'));
    }

    public function testUserCannotEditPost(): void
    {
        $user = $this->createAdmin();

        Post::factory()->create();

        $this->actingAs($user, 'user')
            ->json('get', self::EDIT_POST_URI)
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
            ->json('put', self::UPDATE_POST_URI, $params)
            ->assertUnauthorized();
    }
}
