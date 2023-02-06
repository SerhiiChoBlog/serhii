<?php

declare(strict_types=1);

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $post_id
 * @property int $user_id
 * @property string $comment
 * @property int|null $comment_id
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
            'post_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'comment' => ['required', 'string', 'min:4', 'max:1000'],
            'comment_id' => ['nullable', 'integer'],
        ];
    }
}
