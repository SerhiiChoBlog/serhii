<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Books;

use App\Http\Requests\Admin\Request;
use Illuminate\Http\UploadedFile;

/**
 * @property string $title
 * @property string $book_author_id
 * @property string $rate
 * @property UploadedFile|null $image
 * @property string $read_at
 */
class StoreRequest extends Request
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'min:5', 'max:190'],
            'book_author_id' => ['required', 'numeric', 'exists:book_authors,id'],
            'read_at' => ['required', 'date'],
            'rate' => ['nullable', 'numeric', 'min:1', 'max:5'],
            'image' => ['nullable', 'max:4096'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'rate' => request('rate', 5),
        ]);
    }
}
