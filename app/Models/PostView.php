<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property int $post_id
 * @property int $visitor_id
 * @property int|null $amount
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class PostView extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $dates = ['created_at'];

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @return BelongsTo<Post, self>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
