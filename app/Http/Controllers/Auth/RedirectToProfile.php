<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;

trait RedirectToProfile
{
    protected function redirectTo(): string
    {
        return User::isAdmin(request('email'))
            ? RouteServiceProvider::ADMIN_HOME
            : RouteServiceProvider::USER_HOME;
    }
}
