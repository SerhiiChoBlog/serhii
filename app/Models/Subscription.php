<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property string $email
 * @property Carbon|null $confirmed_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Subscription extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];
}
