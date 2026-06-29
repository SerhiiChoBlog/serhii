<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Ban;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ban>
 */
class BanFactory extends Factory
{
    protected $model = Ban::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comment' => $this->faker->sentence,
        ];
    }
}
