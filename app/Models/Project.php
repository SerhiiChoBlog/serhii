<?php

declare(strict_types=1);

namespace App\Models;

use App\CacheKey;
use App\Ttl;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Serhii\Ago\Option;
use Serhii\Ago\TimeAgo;

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

    protected $appends = [
        'pretty_updated_at',
    ];


    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'has_homepage' => 'boolean',
    ];

    /**
     * @return array<string, mixed>
     */
    public static function getCachedProjects(): array
    {
        return Cache::remember(CacheKey::PROJECTS, Ttl::HOUR, static function () {
            return self::query()
                ->select('title', 'language', 'description', 'name', 'stars', 'has_homepage', 'url', 'updated_at')
                ->orderByDesc('updated_at')
                ->get()
                ->toArray();
        });
    }

    /**
     * @return Attribute<string, mixed>
     */
    protected function prettyUpdatedAt(): Attribute
    {
        return Attribute::get(function (): string {
            if ($this->updated_at === null) {
                return '';
            }

            return TimeAgo::trans($this->updated_at, Option::JUST_NOW);
        });
    }
}
