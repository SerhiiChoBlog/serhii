<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

/**
 * @property-read int $id
 * @property string $name
 * @property string $email
 * @property Carbon $email_verified_at
 * @property string $password
 * @property string $avatar
 * @property string $remember_token
 * @property Collection<int, Role> $roles
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return BelongsToMany<Role>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole(UserRole $role): bool
    {
        return $this->roles()->where('name', $role->value)->exists();
    }

    public static function isAdmin(?string $email): bool
    {
        if (!$email) {
            return false;
        }

        /** @var User|null $user */
        $user = self::query()->where('email', $email)->first();
        return $user?->hasRole(UserRole::ADMIN) ?? false;
    }
}
