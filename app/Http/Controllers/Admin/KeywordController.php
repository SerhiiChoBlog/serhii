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

    public function store($request): void
    {
        $keyword_exist = Keyword::query()
            ->where('name', $request->get('name'))
            ->exists();

        if ($keyword_exist) {
            return;
        }

        Keyword::query()->create($request->only('name'));
    }
}
