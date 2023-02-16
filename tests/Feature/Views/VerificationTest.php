<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class VerificationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Notification::fake();
        Event::fake();
    }

    public function testVerificationPageIsAccessibleByUnverifiedUser(): void
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user, 'user')
            ->get(route('verification.notice'))
            ->assertOk()
            ->assertViewIs('auth.verify');
    }
}
