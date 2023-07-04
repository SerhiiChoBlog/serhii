<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Keyword;

use App\Http\Requests\Admin\Request;

/**
 * @property int $keyword_id
 * @property int $post_id
 */
class DestroyRequest extends Request
{
    /**
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'keyword_id' => ['required', 'integer'],
            'post_id' => ['required', 'integer'],
        ];
    }
}
