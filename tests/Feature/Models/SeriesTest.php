<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Post;
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

    public function testSeriesCanHaveNoPosts(): void
    {
        $this->assertCount(0, $this->series->posts);
    }

    public function testSeriesCanHavePosts(): void
    {
        $posts = Post::factory(2)->create();

        $this->series->posts()->attach($posts);

        $this->assertCount(2, $this->series->posts);
    }
}
