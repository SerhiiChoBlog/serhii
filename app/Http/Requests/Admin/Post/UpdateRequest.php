<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $title
 * @property string $intro
 * @property int[]|null $tags
 * @property bool $is_published
 * @property string $slug
 * @property string|null $content
 */
class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'min:20', 'max:190', 'string'],
            'intro' => ['required', 'max:190', 'string'],
            'tags' => ['nullable', 'array'],
            'is_published' => ['required', 'boolean'],
            'content' => ['nullable'],
            'slug' => ['required', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $tags = null;

        if (request()->has('tags')) {
            $tags = json_decode(request('tags'), flags: JSON_THROW_ON_ERROR);
            $tags = array_map('intval', $tags);
        }

        $this->merge([
            'title' => request()->str('title')->trim()->toString(),
            'intro' => request()->str('intro')->trim()->toString(),
            'tags' => $tags,
            'slug' => request()->str('title')->trim()->slug()->toString(),
            'is_published' => request()->boolean('is-published'),
        ]);
    }
}
