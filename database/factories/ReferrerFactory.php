<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Referrer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReferrerFactory extends Factory
{
    protected $model = Referrer::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->title,
            'site' => $this->faker->slug . '.com',
        ];
    }
}
