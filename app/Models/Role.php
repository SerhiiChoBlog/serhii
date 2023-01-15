<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property string $name
 */
class Role extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var array<int, string>
     */
    protected $guarded = ['id'];
}
