<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SocialName;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property int $post_id
 * @property int $visitor_id
 * @property int|null $user_id
 * @property SocialName $social
 * @property Post $post
 * @property Visitor $visitor
 * @property Carbon $created_at
 */
class SocialShare extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    protected $casts = [
        'social' => SocialName::class,
    ];

    public $timestamps = false;

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
