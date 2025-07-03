<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    /**
     * @return array{
     *   users: LengthAwarePaginator<int, User>,
     *   total: int,
     * }
     */
    public function index(): array
    {
        $users = User::query()
            ->withCount('comments')
            ->with('ban')
            ->orderByDesc('created_at')
            ->paginate(20);

        return [
            'users' => $users,
            'total' => User::query()->count(),
        ];
    }

    public function show(User $user): User
    {
        $user->loadCount('comments');
        $user->load('ban');
        return $user;
    }
}
