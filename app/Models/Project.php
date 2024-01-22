<?php

declare(strict_types=1);

namespace App\Models;

use App\CacheKey;
use App\Ttl;
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
 * @property boolean $has_homepage
 * @property int $stars
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Project extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    public $timestamps = false;

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'has_homepage' => 'boolean',
    ];

    public static function getCachedProjects(): array
    {
        return Cache::remember(CacheKey::PROJECTS, Ttl::DAY, static function () {
            return self::query()
                ->select('title', 'language', 'description', 'name', 'stars', 'has_homepage', 'url', 'updated_at')
                ->orderByDesc('updated_at')
                ->get()
                ->toArray();
        });
    }
}
