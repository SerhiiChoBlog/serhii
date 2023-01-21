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

    public function test_guest_can_visit_the_page(): void
    {
        $this->get(route('password.request'))
            ->assertViewIs('auth.passwords.email')
            ->assertOk();
    }

    public function test_user_can_visit_the_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('password.request'))
             ->assertViewIs('auth.passwords.email')
             ->assertOk();
    }

    public function test_user_receives_email_after_requesting_password_reset(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

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
