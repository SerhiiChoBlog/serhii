<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testGuestCanVisitThePage(): void
    {
        $this->get(route('password.request'))
            ->assertViewIs('auth.passwords.email')
            ->assertOk();
    }

    public function testUserCanVisitThePage(): void
    {
        /** @var User $user */
        $user = $this->createUser();

        $this->actingAs($user)
            ->get(route('password.request'))
            ->assertViewIs('auth.passwords.email')
            ->assertOk();
    }

    public function testUserReceivesEmailAfterRequestingPasswordReset(): void
    {
        /** @var User $user */
        $user = $this->createUser();

        Notification::fake();

        $route = route('password.email');
        $form_params = ['email' => $user->email];

        $this->post($route, $form_params)
            ->assertRedirect();

        Notification::assertSentTo($user, ResetPassword::class);

        $this->assertDatabaseHas('password_resets', [
            'email' => $user->email,
        ]);
    }
}
