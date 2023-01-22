<?php

declare(strict_types=1);

use App\Models\User;

function user(): ?User
{
    /** @var User|null */
    return match (true) {
        auth('admin')->check() => auth('admin')->user(),
        auth('user')->check() => auth('user')->user(),
        default => null,
    };
}
