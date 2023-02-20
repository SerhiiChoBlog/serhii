<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Keyword;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property int $post_id
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
            'name' => ['required', 'max:40'],
            'post_id' => ['required', 'integer'],
        ];
    }
}
