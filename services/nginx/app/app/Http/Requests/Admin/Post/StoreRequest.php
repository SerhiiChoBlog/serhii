<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Post;

use App\Http\Requests\Admin\Request;

/**
 * @property string $title
 * @property int|null $series
 */
class StoreRequest extends Request
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'min:10', 'max:190'],
            'series' => ['nullable', 'exists:series,id'],
        ];
    }
}
