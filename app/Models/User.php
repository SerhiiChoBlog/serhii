<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SignInMethod;
use App\Enums\UserRole;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @property-read int $id
 * @property string $slug
 * @property string $name
 * @property string $secret
 * @property string $email
 * @property Carbon $email_verified_at
 * @property string $password
 * @property int|null $comments_count
 * @property SignInMethod $sign_in_method
 * @property string $avatar
 * @property string $remember_token
 * @property Collection<int, Role> $roles
 * @property Collection<int, Badge> $badges
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Authenticatable implements MustVerifyEmail
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
        'sign_in_method' => SignInMethod::class,
    ];

    /**
     * @return BelongsToMany<Role>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @return BelongsToMany<Badge>
     */
    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class);
    }

    /**
     * @return HasMany<Comment>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
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
        $user = self::query()->select('id', 'email')->where('email', $email)->first();
        return $user?->hasRole(UserRole::ADMIN) ?? false;
    }

    public static function generateSecret(string $email): string
    {
        $chunks = md5($email);
        $str1 = Str::random(9);
        $str2 = Str::random(9);

        return $str1 . $chunks . $str2;
    }
}
