<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SetNewPasswordTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guest_can_set_new_password(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $token = $this->app->make('auth.password.broker')->createToken($user);
        $new_password = 'new_password';

        $form_data = [
            'token' => $token,
            'email' => $user->email,
            'password' => $new_password,
            'password_confirmation' => $new_password,
        ];

        $this->post(route('password.update'), $form_data)
            ->assertRedirect(RouteServiceProvider::USER_HOME);

        $this->assertTrue(Hash::check($new_password, $user->fresh()->password));
    }

    public function test_user_can_set_new_password(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $token = $this->app->make('auth.password.broker')->createToken($user);
        $new_password = 'some_new_password';

        $form_data = [
            'token' => $token,
            'email' => $user->email,
            'password' => $new_password,
            'password_confirmation' => $new_password,
        ];

        $this->actingAs($user)
            ->post(route('password.update'), $form_data)
            ->assertRedirect(RouteServiceProvider::USER_HOME);

        $this->assertTrue(Hash::check($new_password, $user->fresh()->password));
    }

    public function test_user_cannot_set_new_password_with_invalid_token(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $new_password = 'some_new_password';

        $form_data = [
            'token' => 'some_invalid_token',
            'email' => $user->email,
            'password' => $new_password,
            'password_confirmation' => $new_password,
        ];

        $this->actingAs($user)
            ->post(route('password.update'), $form_data)
            ->assertRedirect();

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function test_user_cannot_set_new_password_with_email_of_the_other_user(): void
    {
        /** @var User $other_user */
        $other_user = User::factory()->create();

        /** @var User $user */
        $user = User::factory()->create();

        $token = $this->app->make('auth.password.broker')->createToken($user);
        $new_password = 'my_new_password';

        $form_data = [
            'token' => $token,
            'email' => $other_user->email,
            'password' => $new_password,
            'password_confirmation' => $new_password,
        ];

        $this->actingAs($user)
            ->post(route('password.update'), $form_data)
            ->assertRedirect();

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }
}
