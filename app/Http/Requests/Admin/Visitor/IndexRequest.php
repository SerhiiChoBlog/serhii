<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Visitor;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string|null $search
 */
class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'max:190']
        ];
    }
}
