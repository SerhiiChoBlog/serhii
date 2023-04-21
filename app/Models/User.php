<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\BadgeName;
use App\Enums\SignInMethod;
use App\Enums\UserRole;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
 * @property int|null $post_likes_count
 * @property SignInMethod $sign_in_method
 * @property string $avatar
 * @property Ban|null $ban
 * @property string $remember_token
 * @property Collection<int, Role> $roles
 * @property Collection<int, Badge> $badges
 * @property Collection<int, PostLike> $postLikes
 * @property Collection<int, CommentLike> $commentLikes
 * @property Collection<int, Post> $likedPosts
 * @property Collection<int, Comment> $likedComments
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;

    public const POST_COMMENT_FIELDS = 'id,name,slug,avatar,sign_in_method';
    public const DEFAULT_IMAGE_NAME = 'default.svg';

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
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * @return HasOne<Ban>
     */
    public function ban(): HasOne
    {
        return $this->hasOne(Ban::class);
    }

    /**
     * @return HasMany<PostLike>
     */
    public function postLikes(): HasMany
    {
        return $this->hasMany(PostLike::class);
    }

    /**
     * @return hasMany<CommentLike>
     */
    public function commentLikes(): HasMany
    {
        return $this->hasMany(CommentLike::class);
    }

    /**
     * @return BelongsToMany<Post>
     */
    public function likedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_likes');
    }

    /**
     * @return BelongsToMany<Comment>
     */
    public function likedComments(): BelongsToMany
    {
        return $this->belongsToMany(Comment::class, 'comment_likes');
    }

    public static function isAdmin(string $field, ?string $value): bool
    {
        if (!$value) {
            return false;
        }

        /** @var User|null $user */
        $user = self::query()->select('id', $field)->where($field, $value)->first();

        return $user?->hasRole(UserRole::ADMIN) ?? false;
    }

    public static function generateSecret(string $email): string
    {
        $chunks = md5($email);

        $str1 = Str::random(9);
        $str2 = Str::random(9);

        return $str1 . $chunks . $str2;
    }

    public function giveBadge(BadgeName $type): void
    {
        $badges = Badge::query()->where('name', $type)->pluck('id');

        /** @var int|null $badge_id */
        $badge_id = $badges->first();

        if ($badge_id && !$this->hasBadge($type)) {
            $this->badges()->attach([$badge_id]);
        }
    }

    public function hasBadge(BadgeName $type): bool
    {
        return $this->badges()->where('name', $type)->exists();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public static function getBySecret(?string $secret): ?self
    {
        if (!$secret) {
            return null;
        }

        /** @var self|null */
        return self::query()->where('secret', $secret)->first();
    }

    public function likePost(int $post_id): void
    {
        $this->postLikes()->create(['post_id' => $post_id]);
    }

    public function unlikePost(int $post_id): void
    {
        $this->postLikes()->where('post_id', $post_id)->delete();
    }

    public function hasLikedPost(int $post_id): bool
    {
        return $this->postLikes()->where('post_id', $post_id)->exists();
    }
}
