<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\BadgeName;
use App\Models\Badge;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Badge>
 */
class BadgeFactory extends Factory
{
    protected $model = Badge::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $names = BadgeName::all();
        $random_name = $names[array_rand($names)];

        return [
            'name' => $random_name,
            'description' => $this->faker->sentence,
            'icon' => 'icon.webp',
        ];
    }
}
