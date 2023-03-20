<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * @property-read int $id
 * @property string $title
 * @property string $slug
 * @property string|null $intro
 * @property string|null $content
 * @property bool $is_published
 * @property string $image_xs
 * @property string $image_sm
 * @property string $image_lg
 * @property Collection<int, PostContentImage> $images
 * @property Collection<int, SocialShare> $socialShares
 * @property Collection<int, PostView> $postViews
 * @property Collection<int, Tag> $tags
 * @property Collection<int, Keyword> $keywords
 * @property PostPublication|null $postPublication
 * @property Collection<int, Comment> $comments
 * @property int|null $post_views_count
 * @property int|null $social_shares_count
 * @property int|null $comments_shares_count
 * @property int $read_time
 * @property Collection<int, Series> $series
 * @property Video|null $video
 * @property array<int, array<int, string>>|null $social
 * @property string $pretty_created_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $published_at
 */
class Post extends Model
{
    use HasFactory;

    public const COMMON_FIELDS = [
        'id',
        'slug',
        'title',
        'intro',
        'image_sm',
        'image_xs',
        'created_at',
        'read_time',
    ];

    /**
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * @var array<int, string>
     */
    protected $appends = ['pretty_created_at'];

    protected $casts = [
        'slug' => 'string',
        'published_at' => 'datetime',
        'is_published' => 'bool',
    ];

    /**
     * @return BelongsToMany<Tag>
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)
            ->withPivot('is_main')
            ->using(PostTag::class)
            ->orderByDesc('is_main');
    }

    /**
     * @return BelongsToMany<Series>
     */
    public function series(): BelongsToMany
    {
        return $this->belongsToMany(Series::class)
            ->withPivot('part')
            ->orderBy('part');
    }

    /**
     * @return HasMany<PostContentImage>
     */
    public function images(): HasMany
    {
        return $this->hasMany(PostContentImage::class);
    }

    /**
     * @return HasMany<SocialShare>
     */
    public function socialShares(): HasMany
    {
        return $this->hasMany(SocialShare::class);
    }

    /**
     * @return HasMany<PostView>
     */
    public function postViews(): HasMany
    {
        return $this->hasMany(PostView::class);
    }

    /**
     * @return HasMany<Comment>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return HasOne<PostPublication>
     */
    public function postPublication(): HasOne
    {
        return $this->hasOne(PostPublication::class);
    }

    /**
     * @return HasOne<Video>
     */
    public function video(): HasOne
    {
        return $this->hasOne(Video::class);
    }

    /**
     * @return BelongsToMany<Keyword>
     */
    public function keywords(): BelongsToMany
    {
        return $this->belongsToMany(Keyword::class);
    }

    public static function calculateEstimatedReadingTime(string $content): int
    {
        $content = strip_tags($content);
        $word_count = str_word_count($content);
        $wpm = 180;

        $time = round($word_count / $wpm);

        return (int) $time;
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

            return $this->created_at->format('M j, Y');
        });
    }
}
