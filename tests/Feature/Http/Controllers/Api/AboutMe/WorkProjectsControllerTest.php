<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\AboutMe;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class WorkProjectsControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testItReturnsWorkProjects(): void
    {
        $this->getJson('/api/about-me/work-projects')
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'image_uri',
                    'title',
                    'subtitle',
                    'content',
                    'link',
                    'technologies',
                ],
            ]);
    }
}
