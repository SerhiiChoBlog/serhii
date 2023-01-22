<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use App\Models\User;
use App\Services\GenerateSlugService;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class GenerateSlugServiceTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_it_converts_name_to_slug(): void
    {
        $name = 'Alex Johnson';
        $expect = 'alex-johnson';

        $service = new GenerateSlugService($name);
        $actual = $service->handle();

        $this->assertEquals($expect, $actual);
    }

    public function test_it_adds_suffix_number_1_if_slug_already_exist_in_database(): void
    {
        $name = 'Alex Johnson';
        $slug = 'alex-johnson';
        $expect = 'alex-johnson-1';

        User::factory()->create(compact('slug'));

        $service = new GenerateSlugService($name);
        $actual = $service->handle();

        $this->assertEquals($expect, $actual);
    }

    public function test_it_adds_suffix_number_3_if_slug_already_exist_in_database(): void
    {
        $name = 'Anna Korotchaeva';
        $slug = 'anna-korotchaeva';
        $expect = 'anna-korotchaeva-3';

        User::factory()->create(compact('slug'));
        User::factory()->create(['slug' => "{$slug}-1"]);
        User::factory()->create(['slug' => "{$slug}-2"]);

        $service = new GenerateSlugService($name);
        $actual = $service->handle();

        $this->assertEquals($expect, $actual);
    }
}
