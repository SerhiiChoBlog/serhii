<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Books\StoreRequest;
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
        return Book::query()->orderByDesc('is_reading')->paginate(20);
    }

    public function store(StoreRequest $request): void
    {
        /** @var UploadedFile|null $file */
        $file = $request->file('image');

        /** @var array<string, mixed> $valid */
        $valid = $request->validated();

        $data = collect($valid)->merge([
            'slug' => Str::slug($request->title),
            'book_author_id' => $request->book_author_id,
            'rate' => $request->rate,
        ]);

        if ($file) {
            $data->push($this->storeFile($file, $request));
        }

        Book::query()->create($data->toArray());
    }

    public function storeFile(UploadedFile $file, StoreRequest $request): string
    {
        $ext = $file->getClientOriginalExtension();
        $name = Str::slug($request->title) . ".{$ext}";

        /** @var UploadedFile $image */
        $image = Image::make($file)->resize(null, 500, fn ($c) => $c->aspectRatio())->encode($ext);

        Storage::disk('public')->put("books/{$name}", $image);

        return $name;
    }
}
