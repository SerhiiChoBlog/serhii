<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    public function test_generateSecret_method_returns_50_characters_string(): void
    {
        $result = User::generateSecret('my-email@gmail.com');
        $this->assertEquals(50, strlen($result));
    }
}
