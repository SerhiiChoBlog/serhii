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
 * @property string $image_sm
 * @property string $image_lg
 * @property Collection<int, PostContentImage> $images
 * @property Collection<int, SocialShare> $socialShares
 * @property Collection<int, PostView> $postViews
 * @property Collection<int, Tag> $tags
 * @property int|null $post_views_count
 * @property int|null $social_shares_count
 * @property int $read_time
 * @property array<int, array<int, string>>|null $social
 * @property string $pretty_created_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $published_at
 */
class Post extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

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
        return $this->belongsToMany(Tag::class);
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
     * @return HasOne<PostPublication>
     */
    public function postPublication(): HasOne
    {
        return $this->hasOne(PostPublication::class);
    }

    /**
     * @param int $exclude_id
     *
     * @return Collection<int, Post>
     */
    public static function getPostsForSidebar(int $exclude_id): Collection
    {
        return self::query()
            ->with('tags:id,name,color')
            ->select('id', 'slug', 'title', 'image_sm')
            ->where('is_published', true)
            ->where('id', '!=', $exclude_id)
            ->inRandomOrder()
            ->limit(3)
            ->get()
            ->shuffle();
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

            return $this->created_at->format('F j, Y');
        });
    }

    public static function calculateEstimatedReadingTime(string $content, int $wpm = 180): int
    {
        $content = strip_tags($content);
        $word_count = str_word_count($content);

        $time = round($word_count / $wpm);

        return (int) $time;
    }
}
