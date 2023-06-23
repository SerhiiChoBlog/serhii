<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property-read int $id
 * @property string $title
 * @property int $rate
 * @property string $image
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
}
