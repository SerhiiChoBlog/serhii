<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $post_id
 * @property int $tag_id
 * @property bool $is_main
*/
class PostTag extends Pivot
{
    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_main' => 'bool',
    ];
}
