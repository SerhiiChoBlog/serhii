<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    use RedirectToProfile;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:user')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    protected function guard(): Guard
    {
        if (Auth::guard('admin')->check()) {
            return Auth::guard('admin');
        }

        if (Auth::guard('user')->check()) {
            return Auth::guard('user');
        }

        $is_admin = User::isAdmin('email', request('email'));

        return Auth::guard($is_admin ? 'admin' : 'user');
    }
}
