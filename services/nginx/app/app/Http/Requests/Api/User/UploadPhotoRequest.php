<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $secret
 */
class UploadPhotoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'photo' => ['required', 'image:allow_svg', 'min:8', 'max:5000'],
            'secret' => ['required', 'string'],
        ];
    }
}
