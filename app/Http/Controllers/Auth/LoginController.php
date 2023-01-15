<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:user')->except('logout');
    }

    protected function guard(): Guard
    {
        $is_admin = request('email') === 'admin@mail.com';

        if ($is_admin) {
            return Auth::guard('web');
        }

        return Auth::guard('user');
    }

    protected function redirectTo(): string
    {
        $is_admin = request('email') === 'admin@mail.com';

        if ($is_admin) {
            return RouteServiceProvider::ADMIN_HOME;
        }

        return RouteServiceProvider::USER_HOME;
    }
}
