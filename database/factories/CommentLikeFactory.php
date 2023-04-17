<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CommentLike;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CommentLike>
 */
class CommentLikeFactory extends Factory
{
    protected $model = CommentLike::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'created_at' => $this->faker->dateTimeBetween('-1 year'),
        ];
    }
}
