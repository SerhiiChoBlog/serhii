<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Ban;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $user_id
 */
class UnbanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer'],
        ];
    }
}
