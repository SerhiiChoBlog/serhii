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
}
