<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\SignInMethod;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;
    use RedirectToProfile;

    public function broker(): PasswordBroker
    {
        return Password::broker('users');
    }

    /**
     * @param User $user
     * @param string $password
     */
    protected function resetPassword($user, $password): void
    {
        $user->password = Hash::make($password);
        $user->sign_in_method = SignInMethod::EMAIL;
        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }
}
