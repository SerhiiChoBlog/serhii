<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\PostLike;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $post_id
 */
class IsLikedRequest extends FormRequest
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
            'post_id' => ['required', 'numeric', 'exists:posts,id'],
        ];
    }
}
