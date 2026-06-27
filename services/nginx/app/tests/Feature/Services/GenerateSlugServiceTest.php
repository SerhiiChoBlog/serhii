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

    public function testItConvertsNameToSlug(): void
    {
        $name = 'Alex Johnson';
        $expect = 'alex-johnson';

        $service = new GenerateSlugService($name);
        $actual = $service->handle();

        $this->assertEquals($expect, $actual);
    }

    public function testItAddsSuffixNumber1IfSlugAlreadyExistInDatabase(): void
    {
        $name = 'Alex Johnson';
        $slug = 'alex-johnson';
        $expect = 'alex-johnson-1';

        User::factory()->create(compact('slug'));

        $service = new GenerateSlugService($name);
        $actual = $service->handle();

        $this->assertEquals($expect, $actual);
    }

    public function testItAddsSuffixNumber3IfSlugAlreadyExistInDatabase(): void
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
