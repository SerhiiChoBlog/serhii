<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    public function profile(): View
    {
        $user = user();

        abort_if(!$user, 404);

        $user->loadCount('comments', 'postLikes');
        $user->load('badges');
        $user->makeHidden('secret');

        return view('users.show', compact('user'));
    }

    public function show(User $user): View
    {
        $user->loadCount('comments');
        $user->load('badges', 'ban');
        $user->makeHidden('secret');

        return view('users.show', compact('user'));
    }
}
