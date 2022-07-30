<?php

declare(strict_types=1);

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string|null $tag
 */
class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tag' => ['nullable', 'string'],
        ];
    }
}
