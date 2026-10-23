<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\PostLike;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $post_id
 */
class StoreRequest extends FormRequest
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
            'post_id' => ['required', 'integer', 'exists:posts,id'],
        ];
    }
}
