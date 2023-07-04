<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookAuthor\StoreRequest;
use App\Models\BookAuthor;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class BookAuthorController extends Controller
{
    /**
     * @return Collection<int, BookAuthor>
     */
    public function search(string $author): Collection
    {
        return BookAuthor::query()
            ->where('name', 'like', "%{$author}%")
            ->get();
    }

    public function store(StoreRequest $request): BookAuthor
    {
        /** @var BookAuthor */
        return BookAuthor::query()
            ->firstOrCreate(
                [
                    'name' => $request->name
                ],
                [
                    'slug' => Str::slug($request->name),
                    'name' => $request->name,
                ],
            );
    }
}
