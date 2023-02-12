<?php

declare(strict_types=1);

namespace App\Models;

use App\Events\NewPostView;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Stevebauman\Location\Location;
use Stevebauman\Location\Position;
use Throwable;

/**
 * @property-read int $id
 * @property string $ip
 * @property string|null $country
 * @property string|null $city
 * @property string|null $code
 * @property Collection<SocialShare> $socialShares
 * @property Collection<PostView> $postViews
 */
class Visitor extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @return HasMany<PostView>
     */
    public function postViews(): HasMany
    {
        return $this->hasMany(PostView::class);
    }

    /**
     * @return HasMany<SocialShare>
     */
    public function socialShares(): HasMany
    {
        return $this->hasMany(SocialShare::class);
    }

    /**
     * @throws QueryException
     */
    public static function getOrCreateVisitor(string $ip): ?self
    {
        $position = null;

        $ip = trim($ip);

        try {
            $location = app(Location::class);

            /** @var Position $position */
            $position = $location->get($ip);
        } catch (Throwable $e) {
            Log::warning($e->getMessage());
        }

        if (!$position) {
            return null;
        }

        /** @var self|null $visitor */
        $visitor = self::query()->where('ip', $ip)->first();

        if ($visitor) {
            return $visitor;
        }

        try {
            /** @var Visitor */
            return self::query()->create([
                'ip' => $ip,
                'country' => $position->countryName,
                'city' => $position->cityName,
                'code' => $position->countryCode,
            ]);
        } catch (Throwable $e) {
            Log::warning($e->getMessage());
            return null;
        }
    }

    public static function incrementPostViews(int $post_id, string $ip): void
    {
        try {
            $visitor = self::getOrCreateVisitor($ip);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return;
        }

        if (!$visitor) {
            return;
        }

        $today_post_view = $visitor
            ->postViews()
            ->where('post_id', $post_id)
            ->whereDate('created_at', today())
            ->first();

        if ($today_post_view || auth('admin')->check()) {
            return;
        }

        if (app()->environment('production')) {
            event(new NewPostView($post_id, $visitor->code ?? 'unknown'));
        }

        $visitor->postViews()->create(compact('post_id'));
    }
}
