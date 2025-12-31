<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property-read int $id
 * @property string $title
 * @property string $description
 * @property string $name
 * @property string $color
 * @property int|null $posts_count
 * @property Collection<int, Post> $posts
 * @property Collection<int, Subscription> $subscriptions
 * @property PostTag|null $pivot
 * @property int $pivot_post_id
 * @property int $pivot_tag_id
 * @property int $pivot_is_main
 */
class Tag extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var list<string>
     */
    protected $guarded = ['id'];

    /**
     * @return BelongsToMany<Post, $this>
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * @return BelongsToMany<Subscription, $this>
     */
    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(Subscription::class);
    }
}
