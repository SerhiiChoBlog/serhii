<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Series;

use App\Http\Requests\Admin\Request;
use JsonException;

/**
 * @property string $title
 * @property string $intro
 * @property string $description
 * @property list<int> $posts
 */
class UpdateRequest extends Request
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'min:2', 'max:190'],
            'intro' => ['required', 'min:2', 'max:190'],
            'description' => ['required', 'min:2'],
            'posts' => ['array'],
            'posts.*' => ['integer'],
        ];
    }

    /**
     * @throws JsonException
     */
    protected function prepareForValidation(): void
    {
        if (request()->has('posts')) {
            $this->merge([
                'posts' => json_decode(request('posts'), true, 512, JSON_THROW_ON_ERROR),
            ]);
        }
    }
}
