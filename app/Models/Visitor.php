<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Visitor extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = ['id'];

    public function pageViews(): HasMany
    {
        return $this->hasMany(PageView::class);
    }
}
