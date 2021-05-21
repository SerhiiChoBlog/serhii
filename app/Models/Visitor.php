<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stevebauman\Location\Location;

/**
 * @property-read int $id
 * @property string $ip
 * @property string $country
 * @property string $city
 * @property string $code
 * @property \App\Models\SocialShare[] $socialShares
 * @property \App\Models\PageView[] $pageViews
 */
class Visitor extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = ['id'];

    public function pageViews(): HasMany
    {
        return $this->hasMany(PageView::class);
    }

    public function socialShares(): HasMany
    {
        return $this->hasMany(SocialShare::class);
    }

    public static function getOrCreateVisitor($ip): Visitor
    {
        $visitor = self::query()->with('pageViews')->where('ip', $ip)->first();
        $location = app(Location::class);

        if (!$visitor) {
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
        $exclude_ips = explode(',', config('app.ips_to_exclude_from_page_views'));

        if (in_array($ip, $exclude_ips, true)) {
            return;
        }

        $visitor = self::getOrCreateVisitor($ip);

        $old_record = $visitor->pageViews->where('slug', $slug)->first();

        if ($old_record) {
            $old_record->increment('views');
            return;
        }

        $visitor->pageViews()->create(compact('slug', 'page_type'));
    }
}
