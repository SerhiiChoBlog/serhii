<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function show(?User $user = null): ?User
    {
        if ($user) {
            $user->loadCount('comments');
            $user->load('badges');
            $user->makeHidden('secret');
        }

        return $user;
    }
}
