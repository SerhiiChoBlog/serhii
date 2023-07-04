<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Books;

use App\Http\Requests\Admin\Request;

/**
 * @property string $title
 * @property string $book_author_id
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
        ];
    }
}
