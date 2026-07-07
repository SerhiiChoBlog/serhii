<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property int $post_id
 * @property string $uri
 * @property string $path
 * @property Post $post
 */
class PostContentImage extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    public $timestamps = false;

    /**
     * @return BelongsTo<Post, $this>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
