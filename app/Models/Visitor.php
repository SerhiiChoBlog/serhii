<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Stevebauman\Location\Location;

/**
 * @property-read int $id
 * @property string $ip
 * @property string $country
 * @property string $city
 * @property string $code
 * @property Collection<SocialShare> $socialShares
 * @property Collection<PageView> $pageViews
 */
class Visitor extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    public function pageViews(): HasMany
    {
        return $this->hasMany(PageView::class);
    }

    public function socialShares(): HasMany
    {
        return $this->hasMany(SocialShare::class);
    }

    /**
     * @throws QueryException
     */
    public static function getOrCreateVisitor($ip): Visitor
    {
        $visitor = self::query()->with('pageViews')->where('ip', $ip)->first();

        if (!$visitor) {
            $location = app(Location::class);
            $position = $location->get($ip);

            $visitor = self::query()->create([
                'ip' => $ip,
                'country' => $position->countryName ?? null,
                'city' => $position->cityName ?? null,
                'code' => $position->countryCode ?? null,
            ]);
        }

        return $visitor;
    }

    public static function incrementPageViews(string $slug, string $page_type, string $ip): void
    {
        try {
            $visitor = self::getOrCreateVisitor($ip);
        } catch (QueryException $e) {
            logger()->warning($e);
            return;
        }

        if ($visitor->pageViews->where('slug', $slug)->first()) {
            return;
        }

        $visitor->pageViews()->create(compact('slug', 'page_type'));
    }
}
