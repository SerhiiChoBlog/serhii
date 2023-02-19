<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Visitor;
use App\Utils\GlobalVisitor;
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
            'ip' => GlobalVisitor::LOCAL_IP,
            'country' => GlobalVisitor::LOCAL_COUNTRY,
            'city' => GlobalVisitor::LOCAL_CITY,
            'code' => GlobalVisitor::LOCAL_CODE,
        ];
    }
}
