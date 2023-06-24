<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property string $title
 * @property int $rate
 * @property string $image
 * @property bool $is_reading
 * @property string $slug
 * @property Carbon $read_at
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
}
