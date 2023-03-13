<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Series;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class SeriesControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const INDEX_URI = '/admin/ajax/series';
    private const EDIT_URI = '/admin/ajax/series/1/edit';
    private const DESTROY_URI = '/admin/ajax/series/1';

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

        $response = $this->actingAs($admin, 'admin')
            ->json('get', self::EDIT_URI)
            ->assertOk();

        $fetched_series = $response->json();

        $this->assertEquals($series->id, $fetched_series['id']);
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
}
