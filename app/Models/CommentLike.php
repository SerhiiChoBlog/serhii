<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property int $comment_id
 * @property int $user_id
 * @property Carbon $created_at
 * @property Comment $comment
 * @property User $user
 */
class CommentLike extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    public $timestamps = false;

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Comment, self>
     */
    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
