<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Ban;

use App\Http\Requests\Admin\Request;

/**
 * @property int $user_id
 * @property string $comment
 * @property bool|null $disapprove_comments
 */
class BanRequest extends Request
{
    /**
     * @return array<string, string[]>
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
