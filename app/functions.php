<?php

declare(strict_types=1);

use App\Models\User;

function user(): ?User
{
    /** @var User|null */
    return match (true) {
        auth()->check() => auth()->user(),
        auth('user')->check() => auth('user')->user(),
        default => null,
    };
}
