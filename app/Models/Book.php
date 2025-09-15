<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Serhii\Ago\TimeAgo;

/**
 * @property-read int $id
 * @property int $book_author_id
 * @property string $title
 * @property int $rate
 * @property string $image
 * @property string $slug
 * @property Carbon $read_at
 * @property string $pretty_read_at
 * @property BookAuthor|null $author
 */
class Book extends Model
{
    use HasFactory;

    public const DEFAULT_IMAGE = 'default.jpg';

    /**
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    public $timestamps = false;

    protected $appends = [
        'pretty_read_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'book_author_id' => 'int',
        'rate' => 'int',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return BelongsTo<BookAuthor, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(BookAuthor::class, 'book_author_id');
    }

    public function getPrettyReadAtAttribute(): string
    {
        return TimeAgo::trans($this->read_at);
    }
}
