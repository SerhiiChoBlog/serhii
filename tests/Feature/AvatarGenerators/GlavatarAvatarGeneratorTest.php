<?php

declare(strict_types=1);

namespace Tests\Feature\AvatarGenerators;

use App\AvatarGenerators\GlavatarAvatarGenerator;
use Tests\TestCase;

class GlavatarAvatarGeneratorTest extends TestCase
{
    public function test_it_returns_null_if_image_doesnt_exist(): void
    {
        $service = new GlavatarAvatarGenerator('kqunyqopl1soqpmnbchu3owerkdhswf@nice.com');
        $result = $service->generate();

        $this->assertNull($result);
    }

    public function test_it_returns_string_if_image_exist(): void
    {
        $service = new GlavatarAvatarGenerator('1990serzhil@gmail.com');
        $result = $service->generate();

        $this->assertIsString($result);
    }

    public function test_it_lowercases_the_email(): void
    {
        $service = new GlavatarAvatarGenerator('1990SERZHIL@gmail.COM');
        $result = $service->generate();

        $this->assertIsString($result);
    }
}
