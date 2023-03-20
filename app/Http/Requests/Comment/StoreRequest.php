<?php

declare(strict_types=1);

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $post_id
 * @property string $secret
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
            'post_id' => ['required', 'integer', 'exists:posts,id'],
            'secret' => ['required', 'string'],
            'comment' => ['required', 'string', 'min:4', 'max:1000', 'not_regex:/[А-ЯЁа-яё]+/iu'],
            'comment_id' => ['nullable', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'comment.not_regex' => 'The comment must be in English without Cyrillic letters.',
        ];
    }
}
