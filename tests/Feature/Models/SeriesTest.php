<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Series;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class SeriesTest extends TestCase
{
    use LazilyRefreshDatabase;

    private Series $series;

    public function setUp(): void
    {
        parent::setUp();
        $this->series = Series::factory()->create();
    }

    public function test(): void
    {
        $this->markTestIncomplete();
    }
}
