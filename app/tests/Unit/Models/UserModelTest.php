<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    public function testGenerateSecretMethodReturns50CharactersString(): void
    {
        $result = User::generateSecret('my-email@gmail.com');
        $this->assertEquals(50, strlen($result));
    }
}
