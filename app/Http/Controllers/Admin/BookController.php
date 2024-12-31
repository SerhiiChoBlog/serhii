<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Books\StoreRequest;
use App\Http\Requests\Admin\Books\UpdateFieldRequest;
use App\Models\Book;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BookController extends Controller
{
    /**
     * @return LengthAwarePaginator<Book>
     */
    public function index(): LengthAwarePaginator
    {
        /** @var LengthAwarePaginator<Book> */
        return Book::with('author')->orderByDesc('read_at')->paginate(20);
    }

    public function store(StoreRequest $request): void
    {
        /** @var UploadedFile|null $file */
        $file = $request->file('image');

        Book::query()->create([
            'title' => $request->title,
            'book_author_id' => $request->book_author_id,
            'slug' => Str::slug($request->title),
            'rate' => $request->rate,
            'read_at' => $request->read_at,
            'image' => $this->storeFile($file, $request),
        ]);
    }

    public function updateField(Book $book, UpdateFieldRequest $request): void
    {
        $book->update([
            $request->field_name => $request->field_value,
        ]);
    }

    public function destroy(Book $book): string
    {
        Storage::disk('public')->delete("books/{$book->image}");

        $book->delete();

        return 'The book has been deleted';
    }

    private function storeFile(UploadedFile|null $file, StoreRequest $request): string
    {
        if (!$file) {
            return Book::DEFAULT_IMAGE;
        }

        $ext = $file->getClientOriginalExtension();
        $name = Str::slug($request->title) . ".{$ext}";

        /** @var UploadedFile $image */
        $image = Image::make($file)->resize(null, 500, fn ($c) => $c->aspectRatio())->encode($ext);

        Storage::disk('public')->put("books/{$name}", $image);

        return $name;
    }
}
