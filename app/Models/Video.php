<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property string $video_id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property string $url
 * @property Carbon $published_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Video extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $dates = ['published_at'];
}
