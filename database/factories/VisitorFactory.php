<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Visitor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Visitor>
 */
class VisitorFactory extends Factory
{
    protected $model = Visitor::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ip' => Visitor::LOCAL_IP,
            'country' => Visitor::LOCAL_COUNTRY,
            'city' => Visitor::LOCAL_CITY,
            'code' => Visitor::LOCAL_CODE,
        ];
    }
}
