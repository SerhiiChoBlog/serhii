<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\SocialShare;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $social
 * @property string $secret
 */
class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'social' => ['required', 'string'],
            'secret' => ['nullable', 'string'],
        ];
    }
}
