<?php

declare(strict_types=1);

namespace App\Http\Requests\Subscription;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

/**
 * @property string $email
 * @property Collection<int, string> $tags
 */
class SubscribeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'tags' => ['nullable'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $tags = request()->str('tags');

        $this->merge([
            'tags' => $tags->isEmpty() ? collect([]) : $tags->explode(','),
        ]);
    }
}
