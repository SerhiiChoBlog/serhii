<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\BadgeName;
use App\Enums\FeedType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Serhii\Ago\TimeAgo;

/**
 * @property-read int $id
 * @property int $user_id
 * @property int|null $badge_id
 * @property int|null $comment_id
 * @property int|null $post_id
 * @property string $title
 * @property string $content
 * @property FeedType $type
 * @property Carbon $date
 * @property User $user
 * @property Comment|null $comment
 * @property Post|null $post
 * @property Badge|null $badge
 */
class Feed extends Model
{
    use HasFactory;

    protected $table = 'feed';

    protected $appends = [
        'pretty_date',
    ];

    /**
     * @var list<string>
     */
    protected $guarded = ['id'];

    public $timestamps = false;

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'type' => FeedType::class,
        'date' => 'datetime',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Comment, $this>
     */
    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }

    /**
     * @return BelongsTo<Badge, $this>
     */
    public function badge(): BelongsTo
    {
        return $this->belongsTo(Badge::class);
    }

    /**
     * @return BelongsTo<Post, $this>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public static function giveBadgeFeedItem(User $user, BadgeName $badge_name, ?Carbon $date = null): void
    {
        $badge = Badge::query()->where('name', $badge_name)->firstOrFail();

        $attributes = [
            'badge_id' => $badge->id,
            'type' => FeedType::BADGE,
        ];

        if ($date) {
            $attributes['date'] = $date;
        }

        $user->feed()->create($attributes);
    }

    public static function giveCommentFeedItem(Comment $comment): void
    {
        $comment->user->feed()->create([
            'comment_id' => $comment->id,
            'post_id' => $comment->post->id,
            'type' => FeedType::COMMENT,
            'date' => $comment->created_at,
        ]);
    }

    public static function givePostLikeFeedItem(User $user, PostLike $like): void
    {
        $user->feed()->create([
            'post_id' => $like->post->id,
            'type' => FeedType::POST_LIKE,
            'date' => $like->created_at,
        ]);
    }

    public static function giveCommentLikeFeedItem(User $user, CommentLike $like): void
    {
        $user->feed()->create([
            'comment_id' => $like->comment->id,
            'post_id' => $like->comment->post->id,
            'type' => FeedType::COMMENT_LIKE,
            'date' => $like->created_at,
        ]);
    }

    /**
     * @return Attribute<string, mixed>
     */
    protected function prettyDate(): Attribute
    {
        return Attribute::get(function (): string {
            /** @phpstan-ignore-next-line */
            if ($this->date === null) {
                return '';
            }

            return TimeAgo::trans($this->date);
        });
    }
}
