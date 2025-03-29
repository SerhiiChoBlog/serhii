<?php

declare(strict_types=1);

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $secret
 * @property int $comment_id
 */
class LikeRequest extends FormRequest
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
            'secret' => ['required', 'string'],
            'comment_id' => ['required', 'integer'],
        ];
    }
}
