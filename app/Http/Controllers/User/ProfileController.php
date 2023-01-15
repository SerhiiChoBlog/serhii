<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use Illuminate\Contracts\View\View;

class ProfileController
{
    public function show(): View
    {
        return view('user.profile');
    }
}
