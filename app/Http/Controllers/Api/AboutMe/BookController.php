<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\AboutMe;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;

class BookController extends Controller
{
    /**
     * @return LengthAwarePaginator<int, Book>
     */
    public function __invoke(): LengthAwarePaginator
    {
        /** @var LengthAwarePaginator<int, Book> */
        return Book::with('author')
            ->orderByDesc('read_at')
            ->paginate(20);
    }
}
