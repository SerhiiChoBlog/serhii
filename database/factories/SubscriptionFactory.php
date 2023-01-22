<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Subscription;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Subscription>
 */
class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    /**
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->email(),
            'slug' => Str::random(50),
        ];
    }

    public function confirmed(): self
    {
        return $this->state(function (array $attributes) {
            return ['confirmed_at' => now()];
        });
    }
}
