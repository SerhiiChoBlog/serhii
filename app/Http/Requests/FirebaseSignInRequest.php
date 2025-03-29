<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\SignInMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @property string $name
 * @property string $email
 * @property string|null $photo_url
 * @property string $sign_in_method
 */
class FirebaseSignInRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, string[]|Enum[]>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'sign_in_method' => ['required', new Enum(SignInMethod::class)],
            'photo_url' => ['nullable', 'string'],
        ];
    }
}
