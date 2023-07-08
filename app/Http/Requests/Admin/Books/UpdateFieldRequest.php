<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Books;

use App\Http\Requests\Admin\Request;

/**
 * @property string $field_name
 * @property string $field_value
 */
class UpdateFieldRequest extends Request
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'field_name' => ['required', 'in:title,read_at,rate'],
            'field_value' => ['required', 'string'],
        ];
    }
}
