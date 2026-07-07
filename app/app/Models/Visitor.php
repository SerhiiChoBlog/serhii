<?php

declare(strict_types=1);

namespace App\Models;

use App\Events\NewPostView;
use App\Utils\GlobalVisitor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property-read int $id
 * @property string $ip
 * @property string|null $country
 * @property string|null $city
 * @property string|null $code
 * @property Collection<int, SocialShare> $socialShares
 * @property Collection<int, PostView> $postViews
 * @property boolean $is_blocked
 * @property boolean $is_robot
 */
class Visitor extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    protected $casts = [
        'is_blocked' => 'boolean',
        'is_robot' => 'boolean',
    ];

    /**
     * @return HasMany<PostView, $this>
     */
    public function postViews(): HasMany
    {
        return $this->hasMany(PostView::class);
    }

    /**
     * @return HasMany<SocialShare, $this>
     */
    public function socialShares(): HasMany
    {
        return $this->hasMany(SocialShare::class);
    }

    public static function incrementPostViews(int $post_id): void
    {
        $visitor = GlobalVisitor::getInstance()->get();

        if (!$visitor || $visitor->is_robot) {
            return;
        }

        if ($visitor->hasRecentPostView($post_id) || auth('admin')->check()) {
            return;
        }

        if (app()->isProduction()) {
            event(new NewPostView($post_id, $visitor->code ?? 'unknown'));
        }

        $visitor->postViews()->create(compact('post_id'));
    }

    private function hasRecentPostView(int $post_id): bool
    {
        $latest = $this
            ->postViews()
            ->where('post_id', $post_id)
            ->latest('created_at')
            ->first();

        return $latest && $latest->created_at->gt(now()->subMinute());
    }

    /**
     * @return Collection<int, array{int, int}>
     */
    public static function getGoogleCrawlersIpsMatches(): Collection
    {
        return collect([
            [1089052672, 1089060863], // 64.233.160.0 – 64.233.191.255
            [1113980928, 1123639295], // 66.102.0.0 – 66.102.15.255
            [1123631104, 1123639295], // 66.249.64.0 – 66.249.95.255
            [1208926208, 1208942591], // 72.14.192.0 – 72.14.255.255
            [1249705984, 1249771519], // 74.125.0.0 – 74.125.255.255
            [3512041472, 3512074239], // 209.85.128.0 – 209.85.255.255
            [3639549952, 3639558143], // 216.239.32.0 – 216.239.63.255
            [1074921472, 1074925567], // 64.18.0.0 - 64.18.15.255
            [1823541248, 1823543295], // 108.177.8.0 - 108.177.15.255
            [2899902464, 2899910655], // 172.217.0.0 - 172.217.31.255
            [2915172352, 2915237887], // 173.194.0.0 - 173.194.255.255
            [3481178112, 3481182207], // 207.126.144.0 - 207.126.159.255
            [3627728896, 3627737087], // 216.58.192.0 - 216.58.223.255
        ]);
    }

    /**
     * @return Collection<int, self>
     */
    public static function getRobots(): Collection
    {
        /** @var Collection<int, Visitor> $visitors */
        $visitors = self::query()
            ->withCount('postViews')
            ->get();

        $ranges = self::getGoogleCrawlersIpsMatches();

        return $visitors->filter(function (Visitor $visitor) use ($ranges) {
            $long_ip = ip2long($visitor->ip);

            if (!$long_ip) {
                return false;
            }

            return $ranges->contains(fn (array $range) => $long_ip >= $range[0] && $long_ip <= $range[1]);
        });
    }
}
