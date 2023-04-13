<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\WpPagerUser;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $host
 * @property bool $is_active
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
            'host' => ['string'],
            'is_active' => ['boolean'],
        ];
    }
}
