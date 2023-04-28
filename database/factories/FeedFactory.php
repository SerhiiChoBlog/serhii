<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\FeedType;
use App\Models\Feed;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Feed>
 */
class FeedFactory extends Factory
{
    protected $model = Feed::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(FeedType::all()),
            'date' => $this->faker->dateTime,
        ];
    }
}
