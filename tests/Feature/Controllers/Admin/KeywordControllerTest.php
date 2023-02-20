<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Admin;

use App\Models\Keyword;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class KeywordControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const SEARCH_URI = '/admin/ajax/keywords/search/';

    public function testCanSearchKeyword(): void
    {
        $andrew_keyword = Keyword::factory()->create(['name' => 'andrew']);
        $tate_keyword = Keyword::factory()->create(['name' => 'tate']);
        $admin = $this->createAdmin();

        $resp = $this->actingAs($admin, 'admin')
            ->json('get', self::SEARCH_URI . 'andrew')
            ->assertOk();

        $resp->assertJson([[
            'id' => $andrew_keyword->id,
            'name' => $andrew_keyword->name,
        ]]);
    }

    public function testSearchingKeywordReturnsMultipleKeywords(): void
    {
        $andrew_keyword = Keyword::factory()->create(['name' => 'andrew tate']);
        $tristan_keyword = Keyword::factory()->create(['name' => 'tristan tate']);
        $admin = $this->createAdmin();

        $resp = $this->actingAs($admin, 'admin')
            ->json('get', self::SEARCH_URI . 'tate')
            ->assertOk();

        $resp->assertJson([
            [
                'id' => $andrew_keyword->id,
                'name' => $andrew_keyword->name,
            ],
            [
                'id' => $tristan_keyword->id,
                'name' => $tristan_keyword->name,
            ],
        ]);
    }
}
