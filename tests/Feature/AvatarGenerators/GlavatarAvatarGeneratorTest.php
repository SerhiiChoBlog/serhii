<?php

declare(strict_types=1);

namespace Tests\Feature\AvatarGenerators;

use App\AvatarGenerators\GlavatarAvatarGenerator;
use Tests\TestCase;

class GlavatarAvatarGeneratorTest extends TestCase
{
    public function testItReturnsNullIfImageDoesntExist(): void
    {
        $service = new GlavatarAvatarGenerator('kqunyqopl1soqpmnbchu3owerkdhswf@nice.com');
        $result = $service->generate();

        $this->assertNull($result);
    }

    public function testItReturnsStringIfImageExist(): void
    {
        $service = new GlavatarAvatarGenerator('1990serzhil@gmail.com');
        $result = $service->generate();

        $this->assertIsString($result);
    }

    public function testItLowercasesTheEmail(): void
    {
        $service = new GlavatarAvatarGenerator('1990SERZHIL@gmail.COM');
        $result = $service->generate();

        $this->assertIsString($result);
    }
}
