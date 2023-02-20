<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keyword;
use Illuminate\Support\Collection;

class KeywordController extends Controller
{
    /**
     * @return Collection<int, Keyword>
     */
    public function search(string $keyword): Collection
    {
        return Keyword::query()
            ->where('name', 'like', "%{$keyword}%")
            ->get();
    }
}
