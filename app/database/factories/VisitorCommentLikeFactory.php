<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\VisitorCommentLike;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VisitorCommentLike>
 */
class VisitorCommentLikeFactory extends Factory
{
    protected $model = VisitorCommentLike::class;

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
