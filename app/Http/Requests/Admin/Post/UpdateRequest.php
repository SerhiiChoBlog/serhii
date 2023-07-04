<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Post;

use App\Http\Requests\Admin\Request;

/**
 * @property string $title
 * @property string $intro
 * @property int|null $tag_id
 * @property int[]|null $tags
 * @property bool $is_published
 * @property string|null $content
 */
class UpdateRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'min:10', 'max:190', 'string'],
            'intro' => ['required', 'max:190', 'string'],
            'tags' => ['nullable', 'array'],
            'tag_id' => ['nullable', 'integer'],
            'is_published' => ['required', 'boolean'],
            'content' => ['nullable'],
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
            'tag_id' => request('tag_id') ? request()->integer('tag_id') : null,
            'tags' => $tags,
            'is_published' => request()->boolean('is-published'),
        ]);
    }
}
