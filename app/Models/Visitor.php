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
 * @property Collection<SocialShare> $socialShares
 * @property Collection<PostView> $postViews
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

    public static function incrementPostViews(int $post_id, string $ip): void
    {
        $visitor = GlobalVisitor::getInstance()->get();

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

    /**
     * @return Collection<int, array{int, int}>
     */
    public static function getGoogleCrawlersIpsMatches(): Collection
    {
        return collect([
            [1089052672, 1089060863],
            [1113980928, 1123639295],
            [1123631104, 1123639295],
            [1208926208, 1208942591],
            [1249705984, 1249771519],
            [3512041472, 3512074239],
            [3639549952, 3639558143],
            [1074921472, 1074925567],
            [1823541248, 1823543295],
            [2899902464, 2899910655],
            [2915172352, 2915237887],
            [3481178112, 3481182207],
            [3627728896, 3627737087],
        ]);
    }
}
