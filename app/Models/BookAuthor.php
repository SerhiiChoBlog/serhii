<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property-read int $id
 * @property string $name
 * @property string $slug
 * @property Collection<int, Book> $books
 */
class BookAuthor extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    public $timestamps = false;

    /**
     * @return HasMany<Book, $this>
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
