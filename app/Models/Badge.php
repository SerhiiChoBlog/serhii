<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\BadgeName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property BadgeName $name
 * @property string $description
 * @property string $icon
 * @property Collection<int, User> $users
 */
class Badge extends Model
{
    use HasFactory;

    public const POST_LIKES = 10;
    public const POST_COMMENTS = 10;

    protected $guarded = ['id'];

    public $timestamps = false;

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'name' => BadgeName::class,
    ];

    /**
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
