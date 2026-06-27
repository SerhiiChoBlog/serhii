<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\SocialShare;

use App\Enums\SocialName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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

    /**
     * @return array<string, string[]|Enum[]>
     */
    public function rules(): array
    {
        return [
            'social' => ['required', 'string', new Enum(SocialName::class)],
            'secret' => ['nullable', 'string'],
        ];
    }
}
