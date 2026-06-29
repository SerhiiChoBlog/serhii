<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Keyword;

use App\Http\Requests\Admin\Request;

/**
 * @property string $name
 * @property int $post_id
 */
class StoreRequest extends Request
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:40'],
            'post_id' => ['required', 'integer', 'exists:posts,id'],
        ];
    }
}
