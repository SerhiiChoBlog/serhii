<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    /**
     * @return array{
     *   users: Collection<int, User>,
     *   total: int,
     * }
     */
    public function index(): array
    {
        /** @var Collection<int, User> */
        $users = User::query()
            ->limit(20)
            ->orderByDesc('created_at')
            ->get();

        return [
            'users' => $users,
            'total' => User::query()->count(),
        ];
    }
}
