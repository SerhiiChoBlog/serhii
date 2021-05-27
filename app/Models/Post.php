<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property \App\Models\PostContentImage[] $images
 * @property \App\Models\SocialShare[] $socialShares
 * @property \App\Models\PageView[] $pageViews
 * @property \App\Models\Tag[] $tags
 * @property string $pretty_created_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['pretty_created_at'];
    protected $casts = ['slug' => 'string'];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PostContentImage::class);
    }

    public function socialShares(): HasMany
    {
        return $this->hasMany(SocialShare::class);
    }

    public function pageViews(): HasMany
    {
        return $this->hasMany(PageView::class, 'slug', 'slug');
    }

    public function getPrettyCreatedAtAttribute(): string
    {
        if ($this->created_at->isToday()) {
            return 'Today';
        }

        if ($this->created_at->isYesterday()) {
            return 'Yesterday';
        }

        $date = $this->created_at->format('d F');

        if ($this->created_at->year === now()->year) {
            return $date;
        }

        return sprintf("%s %s", $date, $this->created_at->year);
    }

    /**
     * @return \Illuminate\Support\Collection<Post>
     */
    public static function getPublishedPosts(): Collection
    {
        return self::query()
            ->with('tags:id,name,color')
            ->select('id', 'slug', 'title', 'intro', 'image_sm', 'created_at')
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
