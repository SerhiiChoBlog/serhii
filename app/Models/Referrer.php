<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Serhii\Ago\TimeAgo;

/**
 * @property-read int $id
 * @property string $site
 * @property int $hits
 * @property string $pretty_updated_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Referrer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['pretty_updated_at'];

    /**
     * @return Attribute<string, mixed>
     */
    protected function prettyUpdatedAt(): Attribute
    {
        $get = function (): string {
            /** @phpstan-ignore-next-line */
            if ($this->updated_at === null) {
                return '';
            }

            return TimeAgo::trans($this->updated_at);
        };

        return new Attribute($get);
    }
}
