<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Series;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $title
 * @property string $intro
 */
class StoreRequest extends FormRequest
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
            'title' => ['required', 'min:2', 'max:190'],
            'intro' => ['required', 'min:2', 'max:190'],
        ];
    }
}
