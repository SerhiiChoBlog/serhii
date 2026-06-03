<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testGuestCanVisitPage(): void
    {
        $this->get(route('home'))->assertOk()->assertViewIs('home');
    }

    public function testAdminCanVisitPage(): void
    {
        $user = User::factory()->makeOne();

        $this->actingAs($user, 'admin')
            ->get(route('home'))
            ->assertOk()
            ->assertViewIs('home');
    }
}
