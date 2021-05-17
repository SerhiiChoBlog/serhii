<?php

namespace App\Http\Requests\Api\PageViewController;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $slug
 * @property-read string $page_type
 */
class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slug' => 'required|string',
            'page_type' => 'required|string',
        ];
    }
}
