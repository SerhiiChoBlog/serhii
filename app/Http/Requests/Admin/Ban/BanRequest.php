<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Ban;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $user_id
 * @property string $comment
 * @property bool|null $disapprove_comments
 */
class BanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer'],
            'comment' => ['required', 'string', 'min:5', 'max:190'],
            'disapprove_comments' => ['nullable', 'boolean'],
        ];
    }
}
