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
 * @property Visitor|null $visitor
 * @property Post|null $post
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class PostView extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @return BelongsTo<Post, $this>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @return BelongsTo<Visitor, $this>
     */
    public function visitor(): BelongsTo
    {
        return $this->belongsTo(Visitor::class);
    }
}
