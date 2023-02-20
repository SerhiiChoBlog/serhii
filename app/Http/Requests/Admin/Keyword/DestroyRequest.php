<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Keyword;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $keyword_id
 * @property int $post_id
 */
class DestroyRequest extends FormRequest
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
            'keyword_id' => ['required', 'integer'],
            'post_id' => ['required', 'integer'],
        ];
    }
}
