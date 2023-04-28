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
use Illuminate\Support\Str;
use Serhii\Ago\TimeAgo;

/**
 * @property-read int $id
 * @property int $user_id
 * @property int|null $comment_id
 * @property int|null $post_id
 * @property string $title
 * @property string $content
 * @property FeedType $type
 * @property string|null $image
 * @property string|null $comment
 * @property Carbon $date
 * @property User $user
 */
class Feed extends Model
{
    use HasFactory;

    protected $table = 'feed';

    protected $appends = ['pretty_date'];

    /**
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    public $timestamps = false;

    protected $casts = [
        'type' => FeedType::class,
        'date' => 'datetime',
    ];

    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function giveBadgeFeedItem(User $user, BadgeName $badge_name): void
    {
        $badge = Badge::query()->where('name', $badge_name)->firstOrFail();
        $name = Str::title($badge->name->value);
        $description = Str::lower($badge->description);

        $user->feed()->create([
            'type' => FeedType::BADGE,
            'title' => 'New badge received',
            'content' => "Received a “{$name}” badge because {$user->name} {$description}",
            'image' => "storage/badges/{$badge->icon}",
        ]);
    }

    public static function giveCommentFeedItem(User $user, Comment $comment): void
    {
        $title = $comment->post->title;

        $user->feed()->create([
            'type' => FeedType::COMMENT,
            'title' => 'Commented on the article',
            'content' => "Commented on the article “{$title}” with this message: “{$comment->comment}”",
            'image' => $comment->post->image_xs,
            'url' => route('posts.show', $comment->post),
            'date' => $comment->created_at,
        ]);
    }

    public static function givePostLikeFeedItem(User $user, PostLike $post_like): void
    {
        $user->feed()->create([
            'type' => FeedType::POST_LIKE,
            'title' => 'Liked the article',
            'content' => "Likes the article “{$post_like->post->title}”",
            'image' => $post_like->post->image_xs,
            'url' => route('posts.show', $post_like->post),
            'date' => $post_like->created_at,
        ]);
    }

    public static function giveCommentLikeFeedItem(User $user, CommentLike $comment_like): void
    {
        $title = $comment_like->comment->post->title;
        $comment = $comment_like->comment->comment;
        $name = $comment_like->comment->user->name;

        $user->feed()->create([
            'type' => FeedType::POST_LIKE,
            'title' => 'Liked the article',
            'content' => "Likes the comment “{$comment}” from {$name} on article “{$title}”",
            'image' => "storage/avatars/{$comment_like->comment->user->avatar}",
            'url' => route('users.show', $comment_like->comment->user),
            'date' => $comment_like->created_at,
        ]);
    }

    /**
     * @return Attribute<string, mixed>
     */
    protected function prettyDate(): Attribute
    {
        return Attribute::get(function (): string {
            if ($this->date === null) {
                return '';
            }

            return TimeAgo::trans($this->date);
        });
    }
}
