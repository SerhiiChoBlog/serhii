<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Enums\SignInMethod;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SetNewPasswordTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testGuestCanSetNewPassword(): void
    {
        $user = $this->createUser();

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

    public function testUserCanSetNewPassword(): void
    {
        $user = $this->createUser();

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

    public function testSettingNewPasswordSetsSignInMethodToEmail(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['sign_in_method' => SignInMethod::GOOGLE]);

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

        $this->assertSame(SignInMethod::EMAIL, $user->fresh()->sign_in_method);
    }

    public function testUserCannotSetNewPasswordWithInvalidToken(): void
    {
        $user = $this->createUser();

        $new_password = 'some_new_password';

        $form_data = [
            'token' => 'some_invalid_token',
            'email' => $user->email,
            'password' => $new_password,
            'password_confirmation' => $new_password,
        ];

        $this->actingAs($user)
            ->post(route('password.update'), $form_data)
            ->assertSessionHasErrors('email');

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function testUserCannotSetNewPasswordWithEmailOfTheOtherUser(): void
    {
        $other_user = $this->createUser();

        /** @var User $user */
        $user = $this->createUser();

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
            ->assertSessionHasErrors('email');

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }
}
