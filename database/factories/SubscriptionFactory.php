<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Subscription;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
}
