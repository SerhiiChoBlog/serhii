<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Referrer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReferrerFactory extends Factory
{
    protected $model = Referrer::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->title,
            'site' => $this->faker->slug . '.com',
            'hash' => Str::random(5),
            'hits' => 0,
        ];
    }
}
