<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Books\UpdateRequest;
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
        return Book::query()->orderByDesc('is_reading')->paginate(20);
    }

    public function update(Book $book, UpdateRequest $request): void
    {
        $book->update($request->validated());
    }

    public function edit(Book $book): Book
    {
        return $book;
    }
}
