<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Series;

use App\Http\Requests\Admin\Request;

/**
 * @property string $title
 * @property string $intro
 */
class StoreRequest extends Request
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'min:2', 'max:190'],
            'intro' => ['required', 'min:2', 'max:190'],
        ];
    }
}
