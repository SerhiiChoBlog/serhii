<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property int $book_author_id
 * @property string $title
 * @property int $rate
 * @property string $image
 * @property string $slug
 * @property Carbon $read_at
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

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return BelongsTo<BookAuthor, self>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(BookAuthor::class, 'book_author_id');
    }
}
