<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Admin;

use App\Http\Controllers\Admin\SeriesController;
use App\Models\Post;
use App\Models\Series;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Laravel\Facades\Image;
use Mockery;
use Tests\TestCase;

class SeriesControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const INDEX_URI = '/admin/ajax/series';
    private const EDIT_URI = '/admin/ajax/series/1/edit';
    private const DESTROY_URI = '/admin/ajax/series/1';
    private const STORE_URI = '/admin/ajax/series';
    private const UPDATE_URI = '/admin/ajax/series/1';

    public function testSeriesCanBeFetchedByAdmin(): void
    {
        $admin = $this->createAdmin();

        $series = Series::factory()->create();

        $response = $this->actingAs($admin, 'admin')
            ->getJson(self::INDEX_URI)
            ->assertOk();

        $response->assertJsonCount(1, 'series.data');

        $fetched_series = $response->json('series.data')[0];

        $this->assertEquals($series->id, $fetched_series['id']);
    }

    public function testSeriesAreFetchWithPostsInCorrectOrder(): void
    {
        $admin = $this->createAdmin();

        $first_post = Post::factory()->create([
            'created_at' => now()->subDays(2),
        ]);

        $second_post = Post::factory()->create([
            'created_at' => now()->subDay(),
        ]);

        $last_post = Post::factory()->create([
            'created_at' => now(),
        ]);

        /** @var Series $series */
        $series = Series::factory()->create();

        $series->posts()->attach([
            $last_post->id => ['part' => 3],
            $first_post->id => ['part' => 1],
            $second_post->id => ['part' => 2],
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->getJson(self::INDEX_URI)
            ->assertOk();

        $response->assertJsonCount(1, 'series.data');
        $response->assertJsonFragment(['total' => 1]);

        $fetched_series = $response->json('series.data')[0];
        $posts = $fetched_series['posts'];

        $this->assertSame($series->id, $fetched_series['id']);
        $this->assertSame($first_post->id, $posts[0]['id']);
        $this->assertSame($second_post->id, $posts[1]['id']);
        $this->assertSame($last_post->id, $posts[2]['id']);
    }

    public function testGuestCannotFetchSeries(): void
    {
        $this->getJson(self::INDEX_URI)
            ->assertUnauthorized();
    }

    public function testAuthUserCannotFetchSeries(): void
    {
        $user = $this->createUser();

        $this->actingAs($user, 'user')
            ->getJson(self::INDEX_URI)
            ->assertUnauthorized();
    }

    public function testAdminCanFetchSingleSeries(): void
    {
        $admin = $this->createAdmin();

        $series = Series::factory()->create();
        $post = Post::factory()->create();

        $series->posts()->attach($post);

        $response = $this->actingAs($admin, 'admin')
            ->getJson(self::EDIT_URI)
            ->assertOk();

        $fetched_series = $response->json();

        $this->assertEquals($series->id, $fetched_series['id']);
        $this->assertNotEmpty($fetched_series['posts']);
        $this->assertEquals($post->id, $fetched_series['posts'][0]['id']);
    }

    public function testSeriesCanBeDeleted(): void
    {
        $admin = $this->createAdmin();

        Series::factory()->create();

        $this->actingAs($admin, 'admin')
            ->deleteJson(self::DESTROY_URI)
            ->assertOk();

        $this->assertDatabaseEmpty('series');
    }

    public function testSeriesCanBeCreated(): void
    {
        $admin = $this->createAdmin();

        $form_data = [
            'title' => 'Learn JS',
            'intro' => 'Learn JavaScript from scratch',
        ];

        $this->actingAs($admin, 'admin')
            ->postJson(self::STORE_URI, $form_data)
            ->assertCreated();

        $this->assertDatabaseCount('series', 1);

        $this->assertDatabaseHas('series', [
            'title' => $form_data['title'],
            'intro' => $form_data['intro'],
            'description' => SeriesController::TEMPORARY_DESCRIPTION,
            'slug' => 'learn-js',
        ]);
    }

    public function testSeriesCanBeUpdatedWithoutPosts(): void
    {
        Series::factory()->create([
            'title' => 'Learn PHP',
            'intro' => 'Learn PHP from scratch',
            'description' => 'Learn PHP from scratch and become a PHP developer in 2024',
        ]);

        $admin = $this->createAdmin();

        $form_data = [
            'title' => 'Learn PHP New',
            'intro' => 'Learn PHP New from scratch',
            'description' => 'Learn PHP New from scratch and become a PHP developer in 2024',
            'posts' => '[]',
        ];

        $this->actingAs($admin, 'admin')
            ->putJson(self::UPDATE_URI, $form_data)
            ->assertOk();

        $this->assertDatabaseHas('series', [
            'title' => $form_data['title'],
            'intro' => $form_data['intro'],
            'description' => $form_data['description'],
            'slug' => 'learn-php-new',
        ]);
    }

    public function testSeriesCanBeUpdatedWithPosts(): void
    {
        /** @var Collection<int, Post> $posts */
        $posts = Post::factory(2)->create();

        /** @var Series $series */
        $series = Series::factory()->create();

        $admin = $this->createAdmin();

        $form_data = [
            'title' => $series->title,
            'intro' => $series->intro,
            'description' => $series->description,
            'posts' => $posts->pluck('id')->toJson(),
        ];

        $this->actingAs($admin, 'admin')
            ->putJson(self::UPDATE_URI, $form_data)
            ->assertOk();

        /** @var Series $series */
        $series = Series::with('posts')->first();

        $this->assertCount(2, $series->posts);
    }

    public function testSeriesCanBeUpdatedWithImage(): void
    {
        $image_mock = Mockery::mock(ImageInterface::class);
        $image_mock->shouldReceive('cover')->times(3)->andReturnSelf();
        $image_mock->shouldReceive('save')->times(3);

        Image::shouldReceive('decode')
            ->times(3)
            ->andReturn($image_mock);

        /** @var Series $series */
        $series = Series::factory()->create();

        $admin = $this->createAdmin();

        $form_data = [
            'title' => $series->title,
            'intro' => $series->intro,
            'description' => $series->description,
            'posts' => '[]',
            'image' => UploadedFile::fake()->image('js.jpg'),
        ];

        $this->actingAs($admin, 'admin')
            ->putJson(self::UPDATE_URI, $form_data)
            ->assertOk();
    }

    public function testNotProvidingImageFileWillKeepSeriesImagesUntouched(): void
    {
        Image::shouldReceive('decode')->times(0);

        $admin = $this->createAdmin();

        $images = [
            'image_xs' => 'storage/series/xs/some-image.jpg',
            'image_sm' => 'storage/series/sm/some-image.jpg',
            'image_lg' => 'storage/series/lg/some-image.jpg',
        ];

        /** @var Series $series */
        $series = Series::factory()->create($images);

        $params = [
            'title' => $series->title,
            'intro' => $series->intro,
            'description' => $series->description,
            'posts' => '[]',
        ];

        $this->actingAs($admin, 'admin')
            ->putJson(self::UPDATE_URI, $params)
            ->assertOk();

        $this->assertDatabaseHas('series', [
            'id' => $series->id,
            'image_sm' => 'storage/series/sm/some-image.jpg',
            'image_lg' => 'storage/series/lg/some-image.jpg',
            'image_xs' => 'storage/series/xs/some-image.jpg',
        ]);
    }

    public function testUpdatingSeriesPostsPutThemInCorrectOrder(): void
    {
        /** @var Collection<int, Post> $posts */
        $posts = Post::factory(3)->create();

        /** @var Series $series */
        $series = Series::factory()->create();

        $admin = $this->createAdmin();

        $form_data = [
            'title' => $series->title,
            'intro' => $series->intro,
            'description' => $series->description,
            'posts' => json_encode([
                $posts[2]?->id,
                $posts[1]?->id,
                $posts[0]?->id,
            ], JSON_THROW_ON_ERROR),
        ];

        $this->actingAs($admin, 'admin')
            ->putJson(self::UPDATE_URI, $form_data)
            ->assertOk();

        /** @var Series $series */
        $series = Series::with('posts')->first();

        $this->assertDatabaseHas('post_series', [
            'series_id' => $series->id,
            'post_id' => $posts[2]?->id,
            'part' => 1,
        ]);

        $this->assertDatabaseHas('post_series', [
            'series_id' => $series->id,
            'post_id' => $posts[1]?->id,
            'part' => 2,
        ]);

        $this->assertDatabaseHas('post_series', [
            'series_id' => $series->id,
            'post_id' => $posts[0]?->id,
            'part' => 3,
        ]);
    }
}
