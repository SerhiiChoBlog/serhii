<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\BookAuthor;

use App\Http\Requests\Admin\Request;

/**
 * @property string $name
 */
class StoreRequest extends Request
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:40'],
        ];
    }
}
