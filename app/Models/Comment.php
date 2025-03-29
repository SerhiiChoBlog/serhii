<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\FeedType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Serhii\Ago\Option;
use Serhii\Ago\TimeAgo;

/**
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property int|null $visitor_id
 * @property int|null $comment_id
 * @property Collection<int, self> $comments
 * @property Collection<int, CommentLike> $likes
 * @property User $user
 * @property Post $post
 * @property Visitor $visitor
 * @property self|null $parent
 * @property bool $is_subscribed
 * @property bool $is_approved
 * @property string $comment
 * @property string $pretty_created_at
 * @property Carbon $created_at
 */
class Comment extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * @var array<int, string>
     */
    protected $appends = ['pretty_created_at'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Visitor, $this>
     */
    public function visitor(): BelongsTo
    {
        return $this->belongsTo(Visitor::class);
    }

    /**
     * @return HasMany<CommentLike, $this>
     */
    public function likes(): HasMany
    {
        return $this->hasMany(CommentLike::class);
    }

    /**
     * @return BelongsTo<Post, $this>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @return BelongsTo<self, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'comment_id');
    }

    /**
     * @return HasMany<self, $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(self::class);
    }

    /**
     * @return HasMany<Feed, $this>
     */
    public function feed(): HasMany
    {
        return $this->hasMany(Feed::class);
    }

    public function deleteFeedItem(FeedType $type, int $user_id): void
    {
        $this->feed()->where('type', $type)->where('user_id', $user_id)->delete();
    }

    /**
     * @return Attribute<string, mixed>
     */
    protected function prettyCreatedAt(): Attribute
    {
        return Attribute::get(function (): string {
            if ($this->created_at === null) {
                return '';
            }

            return TimeAgo::trans($this->created_at, Option::JUST_NOW);
        });
    }
}
