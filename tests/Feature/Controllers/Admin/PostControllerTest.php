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

    private const CREATE_POST_URI = '/admin/ajax/posts';
    private const UPDATE_POST_URI = '/admin/ajax/posts/';

    public function testUserCannotCreatePost(): void
    {
        $user = User::factory()->create();

        $params = ['title' => 'This is the post title for post'];

        $this->actingAs($user, 'user')
            ->json('post', self::CREATE_POST_URI, $params);

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
            ->json('put', self::UPDATE_POST_URI . $post->id, $params)
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
            ->json('put', self::UPDATE_POST_URI . $post->id, $params)
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

        $images=  [
            'storage/posts/xs/some-image.jpg',
            'storage/posts/sm/some-image.jpg',
            'storage/posts/lg/some-image.jpg',
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
            ->json('put', self::UPDATE_POST_URI . $post->id, $params)
            ->assertOk();

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'image_sm' => "storage/posts/sm/{$post->slug}.jpg",
            'image_lg' => "storage/posts/lg/{$post->slug}.jpg",
            'image_xs' => "storage/posts/xs/{$post->slug}.jpg",
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
            ->json('put', self::UPDATE_POST_URI . $post->id, $params)
            ->assertOk();

        $expect = <<<TEXT
        <p>This is some text here</p>
        <p class="note"><span class="hidden" aria-label="Note">Note. </span>Be careful mate!</p>
        TEXT;

        $this->assertSame($expect, $post->fresh()->content);
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
            ->json('put', self::UPDATE_POST_URI . $post->id, $params)
            ->assertOk();

        $expect = <<<TEXT
        <p>This is some text here</p>
        <p class="tip"><span class="hidden" aria-label="Tip">Tip. </span>Be careful mate!</p>
        TEXT;

        $this->assertSame($expect, $post->fresh()->content);
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
            ->json('put', self::UPDATE_POST_URI . $post->id, $params)
            ->assertOk();

        $expect = <<<TEXT
        <p>This is some text here</p>
        <p class="note"><span class="hidden" aria-label="Warning">Warning. </span>Be careful man!</p>
        TEXT;

        $this->assertSame($expect, $post->fresh()->content);
    }
}
