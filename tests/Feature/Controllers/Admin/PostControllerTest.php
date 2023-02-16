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

    public function test_user_cannot_create_post(): void
    {
        $user = User::factory()->create();

        $params = ['title' => 'This is the post title for post'];

        $this->actingAs($user, 'user')
            ->json('post', self::CREATE_POST_URI, $params);

        $this->assertDatabaseEmpty('posts');
    }

    public function test_admin_can_create_post(): void
    {
        $admin = $this->createAdmin();

        $params = ['title' => 'This is the post title for post'];

        $this->actingAs($admin, 'admin')
            ->json('post', self::CREATE_POST_URI, $params)
            ->assertOk();

        $this->assertDatabaseHas('posts', $params);
    }

    public function test_admin_can_update(): void
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

    public function test_providing_image_file_will_save_them_to_storage(): void
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
}
