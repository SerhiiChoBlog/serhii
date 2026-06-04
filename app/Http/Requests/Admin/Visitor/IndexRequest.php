<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Visitor;

use App\Http\Requests\Admin\Request;

/**
 * @property string|null $search
 * @property string $order
 * @property 'asc'|'desc' $direction
 */
class IndexRequest extends Request
{
    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'max:190'],
            'order' => ['nullable', 'in:id,post_views_count,is_blocked,is_robot,city,country,code,ip'],
            'direction' => ['nullable', 'in:asc,desc'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'order' => request('order', 'id'),
            'direction' => request('direction', 'desc'),
        ]);
    }
}
