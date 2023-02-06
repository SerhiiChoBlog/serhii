<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $post_id
 * @property int $visitor_id
 * @property int $user_id
 * @property int|null $comment_id
 * @property string|null $email
 * @property Collection<int, self> $comments
 * @property bool $is_subscribed
 * @property bool $created_at
 */
class Comment extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * @return HasMany<self>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(self::class);
    }
}
