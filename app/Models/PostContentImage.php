<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property int $post_id
 * @property string $alt
 * @property string $uri
 * @property string $path
 */
class PostContentImage extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
