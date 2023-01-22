<?php

declare(strict_types=1);

namespace Tests\Feature\AvatarGenerators;

use App\AvatarGenerators\GlavatarAvatarGenerator;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GlavatarAvatarGeneratorTest extends TestCase
{
    public function test_it_returns_null_if_image_doesnt_exist(): void
    {
        $service = new GlavatarAvatarGenerator('kqunyqopl1soqpmnbchu3owerkdhswf@nice.com');

        Http::fake([$service->getUrl() => Http::response(null, 404)]);

        $result = $service->generate();

        $this->assertNull($result);
    }

    public function test_it_returns_string_if_image_exist(): void
    {
        $service = new GlavatarAvatarGenerator('1990serzhil@gmail.com');

        Http::fake([$service->getUrl() => Http::response('image')]);

        $result = $service->generate();

        $this->assertIsString($result);
    }
}
