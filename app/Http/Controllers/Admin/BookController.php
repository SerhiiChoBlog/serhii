<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;

class BookController extends Controller
{
    /**
     * @return LengthAwarePaginator<Book>
     */
    public function index(): LengthAwarePaginator
    {
        /** @var LengthAwarePaginator<Book> */
        return Book::query()->paginate(20);
    }
}
