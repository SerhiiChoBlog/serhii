<?php

declare(strict_types=1);

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function createAdmin(): User
    {
        $admin = $this->createUser();

        $role = Role::factory()->create(['name' => 'admin']);

        $admin->roles()->attach([$role->id]);

        return $admin;
    }

    protected function createUser(): User
    {
        return User::factory()->create();
    }
}
