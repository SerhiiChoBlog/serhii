<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Serhii\Ago\TimeAgo;

/**
 * @property-read int $id
 * @property string $title
 * @property string $slug
 * @property string|null $intro
 * @property string|null $content
 * @property bool $is_published
 * @property string $image_sm
 * @property string $image_lg
 * @property Collection $images
 * @property Collection $socialShares
 * @property Collection $pageViews
 * @property Collection $tags
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

    public static function getPostsForSidebar(int $exclude_id): Collection
    {
        return self::query()
            ->with('tags:id,name,color')
            ->select('id', 'slug', 'title', 'image_sm')
            ->where('is_published', true)
            ->where('id', '!=', $exclude_id)
            ->orderByRaw('RAND()')
            ->limit(5)
            ->get()
            ->shuffle();
    }

    protected function prettyCreatedAt(): Attribute
    {
        $get = function () {
            if (!$this->created_at) {
                return '';
            }

            return TimeAgo::trans($this->created_at);
        };

        return new Attribute($get);
    }
}
