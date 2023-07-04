<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Ban;

use App\Http\Requests\Admin\Request;

/**
 * @property int $user_id
 */
class UnbanRequest extends Request
{
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
