<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Series;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class SeriesControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const INDEX_URI = '/admin/ajax/series';
    private const EDIT_URI = '/admin/ajax/series/1/edit';
    private const DESTROY_URI = '/admin/ajax/series/1';
    private const STORE_URI = '/admin/ajax/series';

    public function testSeriesCanBeFetchedByAdmin(): void
    {
        $admin = $this->createAdmin();

        $series = Series::factory()->create();

        $response = $this->actingAs($admin, 'admin')
            ->json('get', self::INDEX_URI)
            ->assertOk();

        $response->assertJsonCount(1, 'data');

        $fetched_series = $response->json('data')[0];

        $this->assertEquals($series->id, $fetched_series['id']);
    }

    public function testGuestCannotFetchSeries(): void
    {
        $this->json('get', self::INDEX_URI)
            ->assertUnauthorized();
    }

    public function testAuthUserCannotFetchSeries(): void
    {
        $user = $this->createUser();

        $this->actingAs($user, 'user')
            ->json('get', self::INDEX_URI)
            ->assertUnauthorized();
    }

    public function testAdminCanFetchSingleSeries(): void
    {
        $admin = $this->createAdmin();

        $series = Series::factory()->create();
        $post = Post::factory()->create();

        $series->posts()->attach($post);

        $response = $this->actingAs($admin, 'admin')
            ->json('get', self::EDIT_URI)
            ->assertOk();

        $fetched_series = $response->json();

        $this->assertEquals($series->id, $fetched_series['id']);
        $this->assertNotEmpty($fetched_series['posts']);
        $this->assertEquals($post->id, $fetched_series['posts'][0]['id']);
    }

    public function testSeriesCanBeDeleted(): void
    {
        $admin = $this->createAdmin();

        $series = Series::factory()->create();

        $this->actingAs($admin, 'admin')
            ->json('delete', self::DESTROY_URI)
            ->assertOk();

        $this->assertDatabaseEmpty('series');
    }

    public function testSeriesCanBeCreated(): void
    {
        $admin = $this->createAdmin();

        $form_data = [
            'title' => 'Learn JS',
            'intro' => 'Learn JavaScript from scratch',
            'description' => 'Learn JavaScript from scratch and become a JavaScript developer in 2023',
            'posts' => [],
        ];

        $this->actingAs($admin, 'admin')
            ->json('post', self::STORE_URI, $form_data)
            ->assertCreated();

        $this->assertDatabaseCount('series', 1);

        $this->assertDatabaseHas('series', [
            'title' => $form_data['title'],
            'intro' => $form_data['intro'],
            'description' => $form_data['description'],
        ]);
    }

    public function testSeriesCanBeCreatedWithPosts(): void
    {
        /** @var Collection<int, Post> $posts */
        $posts = Post::factory()->count(2)->create();

        $admin = $this->createAdmin();

        $form_data = [
            'title' => 'Learn PHP',
            'intro' => 'Learn PHP from scratch',
            'description' => 'Learn PHP from scratch and become a PHP developer in 2024',
            'posts' => $posts->pluck('id')->toArray(),
        ];

        $this->actingAs($admin, 'admin')
            ->json('post', self::STORE_URI, $form_data)
            ->assertCreated();

        /** @var Series $series */
        $series = Series::with('posts')->first();

        $this->assertCount(2, $series->posts);
    }
}
