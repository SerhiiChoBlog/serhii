<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api\AboutMe;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class TestimonialControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testItReturnsTestimonials(): void
    {
        $this->getJson('/api/about-me/testimonials')
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'image_uri',
                    'name',
                    'role',
                    'content',
                    'short',
                ],
            ]);
    }
}
