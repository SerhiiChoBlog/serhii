<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\FeedType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property FeedType $type
 * @property Carbon $date
 * @property User $user
 */
class Feed extends Model
{
    use HasFactory;

    protected $table = 'feed';

    /**
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    public $timestamps = false;

    protected $casts = [
        'type' => FeedType::class,
        'date' => 'date',
    ];

    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
