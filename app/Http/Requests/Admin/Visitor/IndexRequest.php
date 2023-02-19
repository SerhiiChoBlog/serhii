<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Visitor;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string|null $search
 * @property string $order
 * @property bool $desc
 */
class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'max:190'],
            'order' => ['nullable', 'in:id,post_views_count,is_blocked,city,country,code,ip'],
            'desc' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'order' => request('order', 'id'),
            'desc' => (bool) request('desc', true),
        ]);
    }
}
