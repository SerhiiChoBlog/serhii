<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Keyword;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class KeywordTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testWeCanCreateKeyword(): void
    {
        $keyword = Keyword::factory()->create();

        $this->assertDatabaseHas('keywords', [
            'id' => $keyword->id,
            'name' => $keyword->name,
        ]);
    }
}
