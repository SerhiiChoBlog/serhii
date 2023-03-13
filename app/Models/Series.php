<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $image_xs
 * @property string $image_sm
 * @property string $image_lg
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Series extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    protected $table = 'series';
}
