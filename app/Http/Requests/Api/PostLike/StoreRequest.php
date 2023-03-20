<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\PostLike;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $post_id
 * @property string $secret
 */
class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'post_id' => ['required', 'integer', 'exists:posts,id'],
            'secret' => ['required', 'string'],
        ];
    }
}
