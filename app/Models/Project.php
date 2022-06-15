<?php

declare(strict_types=1);

namespace App\Models;

use App\CacheKey;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * @property-read int $id
 * @property string $name
 * @property string $title
 * @property string $url
 * @property string $description
 * @property string $content
 * @property string $language
 * @property int $stars
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Project extends Model
{
    use HasFactory;

    private const ONE_HOUR_IN_SECONDS = 3600;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    public $timestamps = false;

    public static function getCachedProjects(): array
    {
        return Cache::rememberForever(CacheKey::PROJECTS, static function () {
            return self::query()
                ->select('title', 'language', 'description', 'name')
                ->orderByDesc('created_at')
                ->get()
                ->toArray();
        });
    }
}
