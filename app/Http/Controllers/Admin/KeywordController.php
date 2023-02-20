<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Keyword\StoreRequest;
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

    public function store(StoreRequest $request): void
    {
        /** @var Keyword|null $keyword */
        $keyword = Keyword::query()
            ->where('name', $request->name)
            ->first();

        if (!$keyword) {
            $keyword = Keyword::query()->create(['name' => $request->name]);
        }

        $keyword->posts()->attach($request->post_id);
    }
}
