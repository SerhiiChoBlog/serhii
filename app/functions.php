<?php

declare(strict_types=1);

use App\Models\User;

if (!function_exists('user')) {
    function user(): User|null
    {
        /** @var User|null */
        return match (true) {
            auth('admin')->check() => auth('admin')->user(),
            auth('user')->check() => auth('user')->user(),
            default => null,
        };
    }
}
