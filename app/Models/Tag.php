<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property-read int $id
 * @property string $name
 * @property string $color
 */
class Tag extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
