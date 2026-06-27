<?php

declare(strict_types=1);

namespace App\Http\Requests\Subscription;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Stringable;

/**
 * @property string $email
 * @property Stringable $tags
 */
class SubscribeRequest extends FormRequest
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
            'email' => ['required', 'email'],
            'tags' => ['required'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'tags' => request('tags') ? request()->str('tags') : str(''),
        ]);
    }
}
