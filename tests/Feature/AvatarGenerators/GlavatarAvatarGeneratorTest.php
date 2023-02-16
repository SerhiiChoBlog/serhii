<?php

declare(strict_types=1);

namespace Tests\Feature\AvatarGenerators;

use App\AvatarGenerators\GlavatarAvatarGenerator;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GlavatarAvatarGeneratorTest extends TestCase
{
    public function testItReturnsNullIfImageDoesntExist(): void
    {
        $service = new GlavatarAvatarGenerator('kqunyqopl1soqpmnbchu3owerkdhswf@nice.com');

        Http::fake([$service->getUrl() => Http::response(null, 404)]);

        $result = $service->generate();

        $this->assertNull($result);
    }

    public function testItReturnsStringIfImageExist(): void
    {
        $service = new GlavatarAvatarGenerator('1990serzhil@gmail.com');

        Http::fake([$service->getUrl() => Http::response('image')]);

        $result = $service->generate();

        $this->assertIsString($result);
    }
}
