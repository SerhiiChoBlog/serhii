<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class VerificationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    public function test_user_can_verify_the_email(): void
    {
        $user = User::factory()->unverified()->create();

        $params = [
            'id' => $user->id,
            'hash' => sha1($user->getEmailForVerification()),
        ];

        $this->withoutExceptionHandling();

        $this->actingAs($user, 'user')
            ->get(route('verification.verify', $params))
            ->assertRedirect(RouteServiceProvider::USER_HOME)
            ->assertSessionHas('verified', true);
    }
}
