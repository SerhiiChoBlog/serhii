<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property string $name
 * @property string $title
 * @property string $url
 * @property string $description
 * @property string $content
 * @property string $language
 * @property int $stars
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Project extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;
}
