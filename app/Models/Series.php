<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property-read int $id
 * @property string $slug
 * @property string $title
 * @property string $intro
 * @property string $description
 * @property string $image_xs
 * @property string $image_sm
 * @property string $image_lg
 * @property string $color_from
 * @property int|null $posts_count
 * @property string $color_to
 * @property int $read_time
 * @property Collection<int, Post> $posts
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Series extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    protected $table = 'series';

    /**
     * @var array<int, string>
     */
    protected $appends = ['read_time'];

    /**
     * @return BelongsToMany<Post, $this>
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class)
            ->withPivot('part')
            ->orderBy('part');
    }

    /**
     * @return Attribute<float|int|string, never>
     */
    public function readTime(): Attribute
    {
        return Attribute::get(fn () => $this->posts()->sum('read_time'));
    }
}
